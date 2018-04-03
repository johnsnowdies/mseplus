<?php
namespace app\components;

use app\models\News;
use app\models\Stock;
use app\models\StockHistory;
use app\models\Settings;
use app\models\Rates;

class TradeService
{

    private $_newsService;
    private $_campaignService;

    public function __construct(NewsService $newsService, CampaignService $campaignService)
    {
        $this->_newsService = $newsService;
        $this->_campaignService = $campaignService;
    }


    public function increaseTick(){
        // Инкрементация такта
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;
        $tick++;

        $lastTickSettings->value = $tick;
        $lastTickSettings->save(false);
    }


    public function run(){
        $tick = Settings::getKeyValue('lastTick');

        print("Assuming tick #{$tick}\r\n");

        // Вытаскиваем все компании
        $companies = Stock::find()->all();

        foreach($companies as $company){
            print("Trade simulation for {$company->company_name}\r\n");
            $limit = round($company->amount / 2); //50% of shares


            $rate = $this->_newsService->getNewsRate($company,$tick);
            $newsRate = $rate['newsRate'];
            $dealRate = $rate['dealRate'];


            // Запросы на покупки и продажу

            $avg_ask = [];
            $avg_bid = [];


            $falling_rounds = 0;

            for ($i = 0; $i < 15; $i++){
                $current_ask = round(rand( 1, $limit)); // покупка
                $current_bid = round(rand( 1 , $limit)); // продажа


                $avg_ask[] = $current_ask;
                $avg_bid[] = $current_bid;

                if ($current_ask < $current_bid){
                    $falling_rounds++;
                }
            }

            $bancrupt_factor = false;
            if ($falling_rounds > 10){
                $bancrupt_factor = true;
            }

            $ask = round(array_sum($avg_ask) / count($avg_ask)) * $newsRate;
            $bid = round(array_sum($avg_bid) / count($avg_bid)) / $newsRate;

            print("Calculated news rate: {$newsRate}\r\n");
            print("BID requests: {$bid}\r\n");
            print("ASK requests: {$ask}\r\n");

            // Эксперименты Лейши
            /*
            if ($ask >= $bid){
                $behavior = "GROWTH";
                $new_share_price = $company->share_price * ( ($ask/ $limit) + 0.5);
                $new_capitalization = $new_share_price * $company->amount;
            }else{
                $behavior = "FALLING";
                $new_share_price = $company->share_price * (1.5 - ($bid/ $limit));
                $new_capitalization = $new_share_price * $company->amount;
            }

            $delta = round((($new_capitalization / $company->capitalization) * 100) - 100,4);
            $delta_abs = round($new_capitalization - $company->capitalization,2);
            */

            // Рыночек тут
            if ($ask >= $bid){
                $behavior = "GROWTH";
                $new_capitalization = $company->capitalization + round(($ask/$bid) * $dealRate * $company->share_price);
            }else{
                $behavior = "FALLING";
                $new_capitalization = $company->capitalization - round(($bid/$ask) * $dealRate * $company->share_price);
            }

            $new_share_price = $new_capitalization / $company->amount;

            $delta = round((($new_capitalization / $company->capitalization) * 100) - 100,4);
            $delta_abs = round($new_capitalization - $company->capitalization,4);

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
            if ( ($new_capitalization < ($company->initial_capitalization * 0.5)) && ($bancrupt_factor) ){
                $this->_campaignService->bankruptCompany($company,$tick);
            }else{
                $company->save();
            }

        }

    }
}