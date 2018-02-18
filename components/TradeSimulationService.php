<?php
/**
 * Created by PhpStorm.
 * User: eslider
 * Date: 13.02.18
 * Time: 0:15
 */

namespace app\components;

use app\models\News;
use app\models\Stock;
use app\models\StockHistory;
use app\models\Settings;
use app\models\Rates;

class TradeSimulationService
{

    public function runSimulation(){

        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;
        $tick++;

        $lastTickSettings->value = $tick;
        $lastTickSettings->save(false);

        print("Assuming tick #{$tick}\r\n");
        
        $companies = Stock::find()->all();

        foreach($companies as $company){
            print("Trade simulation for {$company->company_name}\r\n");
            $limit = $company->amount / 2; //50% of shares

            $trend = 1;

            if ($company->behavior && $company->delta){
                if ($company->behavior == 'GROWTH'){
                    $trend += ($company->delta / 1000);
                }else{
                    $trend -= ($company->delta / 1000);
                }
            }

            $brokers = $company->fkMarket->max_agents;

            $avg_ask = [];
            $avg_bid = [];

            for ($i = 0; $i < 15; $i++){
                $avg_ask[] = rand( round($trend), $limit * $trend); // рост
                $avg_bid[] = rand( round(1/$trend) , $limit * (1/$trend)); // падение
            }

            $ask = array_sum($avg_ask) / count($avg_ask);
            $bid = array_sum($avg_bid) / count($avg_bid);

            print("BID requests: {$bid}\r\n");
            print("ASK requests: {$ask}\r\n");

            $new_share_price = $company->share_price;
            $behavior = "";

            if ($ask >= $bid){
                $behavior = "GROWTH";  
                $new_capitalization = $company->capitalization + (($ask - $bid) * $company->share_price);
            }else{
                $behavior = "FALLING";
                $new_capitalization = $company->capitalization - (($bid - $ask) * $company->share_price);
            }
            
            $new_share_price = $new_capitalization / $company->amount;

            $diff_capitalization = abs($new_capitalization - $company->capitalization);
            $delta = (100 * $diff_capitalization)/$company->capitalization;

            print("{$behavior} for {$delta}%\r\n");
            print("Capitalization change:{$company->capitalization} -> {$new_capitalization}\r\n");
            print("Share price change: {$company->share_price} -> {$new_share_price}\r\n");
            print("\r\n");

            $rate = new Rates();
            $exchangeRates = $rate->getSystemRates();

            if($company->fkMarket->fkCurrency->currency_short_name == 'SGD'){
                $rate = 1;
            }
            else{
                $rate = $exchangeRates['SGD'][$company->fkMarket->fkCurrency->currency_short_name];
            }
    
            $history = new StockHistory();
            $history->tickId = $tick;
            $history->fk_stock = $company->id;
            $history->capitalization = $new_capitalization;
            $history->share_price = $new_share_price;
            $history->delta = $delta;
            $history->behavior = $behavior;
            $history->save();

            $company->capitalization = $new_capitalization;
            $company->capitalization_in_uu = $new_capitalization * $rate;
            $company->share_price = $new_share_price;
            $company->delta = $delta;
            $company->behavior = $behavior;



            if ($new_capitalization < ($company->initial_capitalization - ($company->initial_capitalization * 0.1) )){

                $capValueable = ($company->initial_capitalization * 100) / $company->fkMarket->max_capitalization;
                $market = $company->fkMarket;

                $news = new News();

                $priorityMessage = "";

                if ($capValueable < 30) {
                    $news->priority = News::PRIORITY_LOW;
                    $priorityMessage = "Незначительной влияние на рынок не привело к каким-либо серьезным последствиям дла отрасли";
                }

                if ($capValueable >= 30 && $capValueable < 70){
                    $news->priority = News::PRIORITY_MEDIUM;
                    $priorityMessage = "Инвесторы обеспокены этим событием, ожидается спад сектора.";
                }


                if ($capValueable >= 70) {
                    $news->priority = News::PRIORITY_HIGH;
                    $priorityMessage = "Брокеры в панике! Новость о банкротстве некогда крупной компании застигла рынок в расплох!";
                }

                $news->title = "Кампания {$company->company_name} обанкротилась!";
                $news->text = "После падения акций до {$company->share_price} {$market->fkCurrency->currency_short_name} 
                кампания остановила торги на бирже {$market->market_short_name}\n{$priorityMessage}";

                $news->fk_market = $market->id;
                $news->type = News::TYPE_POSITIVE;
                $news->sector = $company->sector;
                $news->tick = $tick;
                $news->save(false);

                // Банкрот! 
                $company->delete();
            }else{
                $company->save();
            }

            
        }


    }
}