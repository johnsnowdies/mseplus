<?php
/**
 * Created by PhpStorm.
 * User: eslider
 * Date: 13.02.18
 * Time: 0:15
 */

namespace app\components;

use app\models\Stock;
use app\models\Currencies;
use app\models\Markets;
use yii\helpers\ArrayHelper;

class CampaignService
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

        $stock->company_name = $this->generateCampaignName();
        $stock->amount = rand(100,25000);
        $stock->capitalization = rand (50000, 10000000);
        $stock->share_price = $stock->capitalization / $stock->amount;
        $stock->initial_capitalization = $stock->capitalization;
        $stock->initial_share_price = $stock->share_price;
        $stock->delta = 0;
        $stock->fk_market = $market->id;

        print("<{$stock->company_name}> IPO at {$market->market_short_name}\r\n");
        print("Amount: {$stock->amount}\r\n");
        print("Initial capitalization: {$stock->initial_capitalization}\r\n");
        print("Initial share price: {$stock->initial_share_price}\r\n");

        $stock->save();
    }



    public function runSimulation(){
        $currencies = Currencies::find()->all();

        // Проход по странам
        foreach ($currencies as $currency){

            // Гарик, помоги!
            if ($currency->currency_short_name == 'SGD')
                continue;

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