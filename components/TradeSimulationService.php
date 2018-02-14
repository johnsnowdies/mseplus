<?php
/**
 * Created by PhpStorm.
 * User: eslider
 * Date: 13.02.18
 * Time: 0:15
 */

namespace app\components;

use app\models\Stock;
use app\models\History;
use app\models\Settings;

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

            $ask = rand(0, $limit);
            $bid = rand(0, $limit);

            print("BID requests: {$bid}\r\n");
            print("ASK requests: {$ask}\r\n");

            $new_share_price = $company->share_price;
            $behavior = "";

            if ($ask > $bid){
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

            $history = new History();
            $history->tickId = $tick;
            $history->fk_stock = $company->id;
            $history->capitalization = $new_capitalization;
            $history->share_price = $new_share_price;
            $history->delta = $delta;
            $history->behavior = $behavior;

            $history->save();

            $company->capitalization = $new_capitalization;
            $company->share_price = $new_share_price;
            $company->delta = $delta;
            $company->behavior = $behavior;

            $company->save();
        }


    }
}