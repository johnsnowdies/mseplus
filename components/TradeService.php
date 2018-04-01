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
            $limit = $company->amount / 2; //50% of shares

            $newsRate = $this->_newsService->getNewsRate($company,$tick);


            // Запросы на покупки и продажу

            $avg_ask = [];
            $avg_bid = [];


            $falling_rounds = 0;

            for ($i = 0; $i < 15; $i++){
                $ask_bottom_limit = 1;//round($trend);
                $bid_bottom_limit = 1;//round(1/$trend);

                $ask_top_limit = $limit;
                $bid_top_limit = $limit;

                if ($newsRate != 0 ){
                    $ask_top_limit = round((($limit * $newsRate) > $company->amount ) ? $company->amount :  ($limit * $newsRate));
                    $bid_top_limit = round((($limit * (1/$newsRate)) > $company->amount) ? $company->amount : ($limit * (1/$newsRate)));
                }

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
                $this->_campaignService->bankruptCompany($company,$tick);
            }else{
                $company->save();
            }

        }

    }
}