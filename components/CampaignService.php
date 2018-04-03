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
use app\models\StockHistory;
use Yii;
use yii\helpers\ArrayHelper;

class CampaignService
{
    /**
     * @var NewsService
     */
    private $_newsService;


    public function __construct(NewsService $newsService)
    {
        $this->_newsService = $newsService;
    }

    private function generateCampaignName(){
        $generator = \Nubs\RandomNameGenerator\All::create();
        $rnd = rand(10000,90000);
        return $generator->getName() . " #" . $rnd;
    }

    public function campaignIpo(Markets $market)
    {
        $stock = new Stock();
        $tick = Settings::getKeyValue('lastTick');

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

        $possible_sector = [];

        if ($sectorCampaignCount[Stock::SECTOR_AGRICULTURAL] < $sectorCampaignLimit[Stock::SECTOR_AGRICULTURAL]) {
            $possible_sector[] = Stock::SECTOR_AGRICULTURAL;
        }

        if ($sectorCampaignCount[Stock::SECTOR_INDUSTRIAL] < $sectorCampaignLimit[Stock::SECTOR_INDUSTRIAL]){
            $possible_sector[] = Stock::SECTOR_INDUSTRIAL;
        }

        if ($sectorCampaignCount[Stock::SECTOR_SERVICE] < $sectorCampaignLimit[Stock::SECTOR_SERVICE]){
            $possible_sector[] = Stock::SECTOR_SERVICE;
        }

        $sector = $possible_sector[ rand(0, count($possible_sector)-1)];

        $stock->company_name = $this->generateCampaignName();
        $stock->capitalization = rand($market->getMinCapitalizationInMarketCurrency(), $market->getMaxCapitalizationInMarketCurrency());
        $stock->amount = rand($market->min_amount, $market->max_amount);

        $stock->share_price = $stock->capitalization / $stock->amount;
        $stock->initial_capitalization = $stock->capitalization;
        $stock->initial_share_price = $stock->share_price;
        $stock->delta = 0;
        $stock->delta_abs = 0;
        $stock->fk_market = $market->id;
        $stock->sector = $sector;

        print("<{$stock->company_name}> IPO at {$market->market_short_name}\r\n");
        print("Amount: {$stock->amount}\r\n");
        print("Initial capitalization: {$stock->initial_capitalization}\r\n");
        print("Initial share price: {$stock->initial_share_price}\r\n");

        $stock->save();

        // Создание новости об IPO
        if ($tick != 1){
            // Определяем процент от максимальной капитализации
            $capValueable = ($stock->capitalization * 100) / $market->max_capitalization;
            $priority = "";

            $priorityMessage = "";
            $ttl = 1;

            if ($capValueable < 30) {
                $priority = News::PRIORITY_LOW;
                $priorityMessage = "Инвесторы проявили незначительный интерес к данному IPO";
                $ttl = 2;
            }

            if ($capValueable >= 30 && $capValueable < 70){
                $priority = News::PRIORITY_MEDIUM;
                $priorityMessage = "Инвесторы положительно восприняли IPO этой кампании";
                $ttl = 5;
            }


            if ($capValueable >= 70) {
                $priority = News::PRIORITY_HIGH;
                $priorityMessage = "Рынок возбужден новостью!";
                $ttl = 10;
            }

            $formatedSharePrice = Yii::$app->formatter->format($stock->share_price, ['decimal', 2]);

            $this->_newsService->create(
                $market,
                $stock,
                "Кампания {$stock->company_name} провела IPO",
                $priority,
                "На бирже {$market->market_short_name} было размешено {$stock->amount} акций по цене {$formatedSharePrice} {$market->fkCurrency->currency_short_name} за штуку.\n{$priorityMessage}",
                News::TYPE_POSITIVE,
                $tick,
                $ttl
            );
        }
    }


    public function bankruptCompany(Stock $company, int $tick){
        $capValueable = ($company->initial_capitalization * 100) / $company->fkMarket->max_capitalization;
        $market = $company->fkMarket;

        $news = new News();

        $priorityMessage = "";
        $ttl = 1;

        if ($capValueable < 30) {
            $news->priority = News::PRIORITY_LOW;
            $priorityMessage = "Незначительной влияние на рынок не привело к каким-либо серьезным последствиям дла отрасли";
            $ttl = 1;
        }

        if ($capValueable >= 30 && $capValueable < 70){
            $news->priority = News::PRIORITY_MEDIUM;
            $priorityMessage = "Инвесторы обеспокены этим событием, ожидается спад сектора.";
            $ttl = 5;
        }


        if ($capValueable >= 70) {
            $news->priority = News::PRIORITY_HIGH;
            $priorityMessage = "Брокеры в панике! Новость о банкротстве некогда крупной компании застигла рынок врасплох!";
            $ttl = 10;
        }

        $news->title = "Кампания {$company->company_name} обанкротилась!";
        $news->text = "После падения акций до {$company->share_price} {$market->fkCurrency->currency_short_name} 
                кампания остановила торги на бирже {$market->market_short_name}\n{$priorityMessage}";

        $news->fk_market = $market->id;
        $news->type = News::TYPE_NEGATIVE;
        $news->sector = $company->sector;
        $news->tick = $tick;
        $news->ttl = $ttl;

        $news->save(false);

        // Удаляем все записи из истории
        StockHistory::deleteAll(['fk_stock' => $company->id]);

        // Удаляем кампанию
        $company->delete();
    }


    public function run(){
        $currencies = Currencies::find()->all();

        // Проход по странам
        foreach ($currencies as $currency){

            // Гарик, помоги!
           
            print("\r\n");
            print("Processing {$currency->country}\r\n");
            $markets = Markets::find()->where(['fk_currency' => $currency->id])->all();


            // Проход по биржам
            foreach ($markets as $market){

                while(true){
                    $currentCampaignsCount = Stock::find()->where(['fk_market' => $market->id])->count();

                    // Кампаний меньше квоты
                    if ($currentCampaignsCount < $market->max_companies){
                        print("Campaign quote doesn't reached yet\r\n");
                        $this->campaignIpo($market);
                    }else{
                        print("Campaign quote reached for {$market->market_short_name} current count: {$currentCampaignsCount}!\r\n");
                        break;
                    }
                }

            }
        }
    }

}