<?php
/**
 * Created by PhpStorm.
 * User: eslider
 * Date: 13.02.18
 * Time: 0:15
 */

namespace app\components;

use app\models\News;
use app\models\Settings;
use app\models\Stock;
use app\models\Currencies;
use app\models\Markets;
use app\models\Rates;
use yii\helpers\ArrayHelper;

class CampaignGeneratorService
{
    private function generateCampaignName(){
        $generator = \Nubs\RandomNameGenerator\All::create();
        return $generator->getName();
    }


    private function getMarketCampaignCount($markets){
        $arMarkets = [];
        foreach ($markets as $market){
            $arMarkets[] = $market->id;
        }
        return Stock::find()->where(['fk_market' => $arMarkets])->count();
    }

    private function campaignBankrupt($markets){
        
    }

    private function campaignIpo($market){
        $stock = new Stock();
        $rate = new Rates();
        $exchangeRates = $rate->getSystemRates();
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;

        if($market->fkCurrency->currency_short_name == 'SGD'){
            $rate = 1;
        }
        else{
            $rate = $exchangeRates['SGD'][$market->fkCurrency->currency_short_name];
        }


        // Определение сектора экономики новой кампании
        $sectorCampaignLimit = [
            Stock::SECTOR_AGRICULTURAL => ($market->max_amount * $market->rate_agri) / 100,
            Stock::SECTOR_INDUSTRIAL => ($market->max_amount * $market->rate_indus) / 100,
            Stock::SECTOR_SERVICE => ($market->max_amount * $market->rate_serv) / 100
        ];

        $sectorCampaignCount = [
            Stock::SECTOR_AGRICULTURAL => Stock::find()->where(['fk_market' => $market->id, 'sector' => Stock::SECTOR_AGRICULTURAL])->count(),
            Stock::SECTOR_INDUSTRIAL => Stock::find()->where(['fk_market' => $market->id, 'sector' => Stock::SECTOR_INDUSTRIAL])->count(),
            Stock::SECTOR_SERVICE => Stock::find()->where(['fk_market' => $market->id, 'sector' => Stock::SECTOR_SERVICE])->count(),
        ];

        $sector = null;

        if ($sectorCampaignCount[Stock::SECTOR_AGRICULTURAL] < $sectorCampaignLimit[Stock::SECTOR_AGRICULTURAL]) {
            $sector = Stock::SECTOR_AGRICULTURAL;
        }
        else if ($sectorCampaignCount[Stock::SECTOR_INDUSTRIAL] < $sectorCampaignLimit[Stock::SECTOR_INDUSTRIAL]){
            $sector = Stock::SECTOR_INDUSTRIAL;
        }
        else if ($sectorCampaignCount[Stock::SECTOR_SERVICE] < $sectorCampaignLimit[Stock::SECTOR_SERVICE]){
            $sector = Stock::SECTOR_SERVICE;
        }


        $stock->company_name = $this->generateCampaignName();
        $stock->capitalization = rand($market->min_capitalization / $rate, $market->max_capitalization / $rate);
        $stock->amount = rand($market->min_amount, $market->max_amount);
        $stock->capitalization_in_uu = $stock->capitalization * $rate;
        $stock->share_price = $stock->capitalization / $stock->amount;
        $stock->initial_capitalization = $stock->capitalization;
        $stock->initial_share_price = $stock->share_price;
        $stock->delta = 0;
        $stock->fk_market = $market->id;
        $stock->sector = $sector;

        print("<{$stock->company_name}> IPO at {$market->market_short_name}\r\n");
        print("Amount: {$stock->amount}\r\n");
        print("Initial capitalization: {$stock->initial_capitalization}\r\n");
        print("Initial share price: {$stock->initial_share_price}\r\n");

        $stock->save();

        // Создание новости об IPO
        // Определяем процент от максимальной капитализации

        $capValueable = ($stock->capitalization * 100) / $market->max_capitalization;
        $news = new News();

        $priorityMessage = "";

        if ($capValueable < 30) {
            $news->priority = News::PRIORITY_LOW;
            $priorityMessage = "Инвесторы проявили незначительный интерес к данному IPO";
        }

        if ($capValueable >= 30 && $capValueable < 70){
            $news->priority = News::PRIORITY_MEDIUM;
            $priorityMessage = "Инвесторы положительно восприняли IPO этой кампании";
        }


        if ($capValueable >= 70) {
            $news->priority = News::PRIORITY_HIGH;
            $priorityMessage = "Рынок взбудоражен новостью!";
        }

        $news->title = "Кампания {$stock->company_name} провела IPO";
        $news->text = "На бирже {$market->market_short_name} было размешено {$stock->amount} акций по цене {$stock->share_price} за штуку.\n{$priorityMessage}";
        $news->fk_market = $market->id;
        $news->type = News::TYPE_POSITIVE;
        $news->sector = $stock->sector;
        $news->tick = $tick;
        $news->save(false);
    }



    public function runSimulation(){
        $currencies = Currencies::find()->all();

        // Проход по странам
        foreach ($currencies as $currency){

            // Гарик, помоги!
           
            print("\r\n");
            print("Processing {$currency->country}\r\n");
            $markets = Markets::find()->where(['fk_currency' => $currency->id])->all();
            $currentCampaignsCount = $this->getMarketCampaignCount($markets);

            // Проход по биржам
            foreach ($markets as $market){
                // Кампаний меньше квоты
                if ($currentCampaignsCount < $market->max_companies){
                    print("Campaign quote doesn't reached yet\r\n");
                    $this->campaignIpo($market);
                }
            }
        }
    }

}