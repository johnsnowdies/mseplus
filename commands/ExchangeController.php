<?php

namespace app\commands;

use yii\console\Controller;
use app\components\CampaignService;
use app\components\TradeSimulationService;

use app\models\Rates;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class ExchangeController extends Controller
{
    public function actionRun(){
        print("Exchange service launched\r\n");

        # Run campaign service
        $campaignService = new CampaignService();
        $campaignService->runSimulation();

        # Run trade sumulation service
        $tradeService = new TradeSimulationService();
        $tradeService->runSimulation();

        # Run currency rate recalculate
        $rates = new Rates();
        $rates->recalculateRates();
    }

    public function actionGenerate(){
        for ($i = 1; $i < 3000; $i++){
            # Run campaign service
            $campaignService = new CampaignService();
            $campaignService->runSimulation();
        }

    }

    public function actionTrade()
    {
     
            # Run trade sumulation service
            $tradeService = new TradeSimulationService();
            $tradeService->runSimulation();

            # Run currency rate recalculate
            $rates = new Rates();
            $rates->recalculateRates();
        
    }

   
}
