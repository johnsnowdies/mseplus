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

    private function campaignIpo($markets){
        $stock = new Stock();

        $stock->company_name = $this->generateCampaignName();
        $stock->amount = rand(100,25000);
        $stock->capitalization = rand (50000, 10000000);
        $stock->sum = $stock->capitalization / $stock->amount;

        $market = $markets[0];

        if (count($markets) > 1){
            $market = $markets[rand(0,count($markets)-1)];
        }

        $stock->fk_market = $market->id;

        print("<{$stock->company_name}> IPO at {$market->market_short_name}\r\n");
        print("Amount: {$stock->amount}\r\n");
        print("Capitalization: {$stock->capitalization}\r\n");
        print("Sum: {$stock->sum}\r\n");

        $stock->save();
    }



    public function runSimulation(){
        $currencies = Currencies::find()->all();

        foreach ($currencies as $currency){

            // Гарик, помоги!
            if ($currency->currency_short_name == 'SGD')
                continue;

            print("\r\n");
            print("Processing {$currency->country}\r\n");
            $markets = Markets::find()->where(['fk_currency' => $currency->id])->all();
            $currentCampaignsCount = $this->getMarketCampaignCount($markets);

            // Кампаний меньше квоты
            if ($currentCampaignsCount < $currency->max_companies){
                print("Campaign quote doesn't reached yet\r\n");
                $this->campaignIpo($markets);
            }
        }
    }

}