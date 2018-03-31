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

    public function getNewsRate($company,$currentTick){


        $newsList = News::find()->where([
            'tick' => $currentTick - 1,
            'fk_market' => $company->fk_market,
            'sector' => $company->sector
            ])->all();



        $newsCountByPriority = [
            News::PRIORITY_HIGH => [
                News::TYPE_POSITIVE => 0,
                News::TYPE_NEGATIVE => 0,
            ],

            News::PRIORITY_MEDIUM => [
                News::TYPE_POSITIVE => 0,
                News::TYPE_NEGATIVE => 0,
            ],

            News::PRIORITY_LOW => [
                News::TYPE_POSITIVE => 0,
                News::TYPE_NEGATIVE => 0,
            ]

        ];

        foreach ($newsList as $news){
            if ($news->priority == News::PRIORITY_LOW){
                if ($news->type == News::TYPE_NEGATIVE){
                    $newsCountByPriority[News::PRIORITY_LOW][News::TYPE_NEGATIVE]++;
                }

                if ($news->type == News::TYPE_POSITIVE){
                    $newsCountByPriority[News::PRIORITY_LOW][News::TYPE_POSITIVE]++;
                }
            }

            if ($news->priority == News::PRIORITY_MEDIUM){
                if ($news->type == News::TYPE_NEGATIVE){
                    $newsCountByPriority[News::PRIORITY_MEDIUM][News::TYPE_NEGATIVE]++;
                }

                if ($news->type == News::TYPE_POSITIVE){
                    $newsCountByPriority[News::PRIORITY_MEDIUM][News::TYPE_POSITIVE]++;
                }
            }

            if ($news->priority == News::PRIORITY_HIGH){
                if ($news->type == News::TYPE_NEGATIVE){
                    $newsCountByPriority[News::PRIORITY_HIGH][News::TYPE_NEGATIVE]++;
                }

                if ($news->type == News::PRIORITY_HIGH){
                    $newsCountByPriority[News::PRIORITY_HIGH][News::TYPE_POSITIVE]++;
                }
            }
        }

        $rate = 1;


        foreach ($newsCountByPriority as $key => $value){
            if ($value[News::TYPE_NEGATIVE] > 0){
                if ($key == News::PRIORITY_HIGH)
                    $rate -= 0.75;

                if ($key == News::PRIORITY_MEDIUM)
                    $rate -= 0.5;

                if ($key == News::PRIORITY_LOW)
                    $rate -= 0.25;

            }

            if ($value[News::TYPE_POSITIVE] > 0){
                if ($key == News::PRIORITY_HIGH)
                    $rate += 0.75;

                if ($key == News::PRIORITY_MEDIUM)
                    $rate += 0.5;

                if ($key == News::PRIORITY_LOW)
                    $rate += 0.25;

            }

        }
        return $rate;
    }


    public function increaseTick(){
        // Инкрементация такта
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;
        $tick++;

        $lastTickSettings->value = $tick;
        $lastTickSettings->save(false);
    }

    public function runSimulation(){

        // Инкрементация такта
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;
        $tick++;

        $lastTickSettings->value = $tick;



        print("Assuming tick #{$tick}\r\n");

        // Вытаскиваем все компании
        $companies = Stock::find()->all();

        foreach($companies as $company){
            print("Trade simulation for {$company->company_name}\r\n");

            $limit = $company->amount / 2; //50% of shares

            // Влияние тренда
            $trend = 1;

            if ($company->behavior && $company->delta){
                if ($company->behavior == 'GROWTH'){
                    $trend += 0.25; //round($company->delta);
                }else{
                    $trend -= 0.25;// round($company->delta);
                }
            }

            if ($trend == 0 )
                $trend = 1;



            $newsRate = $this->getNewsRate($company,$tick);

            if ($newsRate == 0 )
                $newsRate = 1;

            // Запросы на покупки и продажу

            $avg_ask = [];
            $avg_bid = [];


            $falling_rounds = 0;

            for ($i = 0; $i < 15; $i++){
                $ask_bottom_limit = 1;//round($trend);
                $ask_top_limit =  $limit;//round((($limit * $trend * $newsRate) > $company->amount ) ? $company->amount :  ($limit * $trend * $newsRate));

                $bid_bottom_limit = 1;//round(1/$trend);
                $bid_top_limit = $limit;// round((($limit * (1/$trend) * (1/$newsRate)) > $company->amount) ? $company->amount - $ask_top_limit: ($limit * (1/$trend) * (1/$newsRate)));


                $current_ask = round(rand( $ask_bottom_limit, $ask_top_limit)); // покупка
                $current_bid = round(rand( $bid_bottom_limit , $bid_top_limit)); // продажа


                $avg_ask[] = $current_ask;
                $avg_bid[] = $current_bid;

                if ($current_ask < $current_bid){
                    $falling_rounds++;
                }
            }

            $bancrupt_factor = false;
            if ($falling_rounds = 15){
                $bancrupt_factor = true;
            }


            $ask = round(array_sum($avg_ask) / count($avg_ask));
            $bid = round(array_sum($avg_bid) / count($avg_bid));

            print("Trend: {$trend}\r\n");
            print("Calculated news rate: {$newsRate}\r\n");
            print("BID requests: {$bid}\r\n");
            print("ASK requests: {$ask}\r\n");


            // Рыночек тут
            if ($ask >= $bid){
                $behavior = "GROWTH";  
                $new_capitalization = $company->capitalization + round(($ask/$bid) * $company->share_price);
            }else{
                $behavior = "FALLING";
                $new_capitalization = $company->capitalization - round(($bid/$ask) * $company->share_price);
            }

            $new_share_price = $new_capitalization / $company->amount;

            $delta = round((($new_capitalization / $company->capitalization) * 100) - 100,2);
            $delta_abs = round($new_capitalization - $company->capitalization,2);

            print("{$behavior} for {$delta}% equal {$delta_abs} {$company->fkMarket->fkCurrency->currency_short_name}\r\n");
            print("Capitalization change:{$company->capitalization} -> {$new_capitalization}\r\n");
            print("Share price change: {$company->share_price} -> {$new_share_price}\r\n");
            print("\r\n");


            $history = new StockHistory();
            $history->tickId = $tick;
            $history->fk_stock = $company->id;
            $history->capitalization = round($new_capitalization,2);
            $history->share_price = round($new_share_price,2);
            $history->delta = $delta;
            $history->delta_abs = $delta_abs;
            $history->behavior = $behavior;
            $history->save();


            $company->capitalization = $new_capitalization;
            $company->share_price = $new_share_price;
            $company->delta = $delta;
            $company->delta_abs = $delta_abs;
            $company->behavior = $behavior;



            // Банкротство

            if ( ($new_capitalization < ($company->initial_capitalization * 0.1)) && ($bancrupt_factor) ){


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
                    $priorityMessage = "Брокеры в панике! Новость о банкротстве некогда крупной компании застигла рынок врасплох!";
                }

                $news->title = "Кампания {$company->company_name} обанкротилась!";
                $news->text = "После падения акций до {$company->share_price} {$market->fkCurrency->currency_short_name} 
                кампания остановила торги на бирже {$market->market_short_name}\n{$priorityMessage}";

                $news->fk_market = $market->id;
                $news->type = News::TYPE_NEGATIVE;
                $news->sector = $company->sector;
                $news->tick = $tick;
                $news->save(false);

                // Удаляем все записи из истории
                StockHistory::deleteAll(['fk_stock' => $company->id]);

                // Удаляем кампанию
                $company->delete();




            }else{
                $company->save();
            }



            
        }


    }
}