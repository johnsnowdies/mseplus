<?php

use app\models\Markets;
use app\models\MarketsHistory;
use app\models\Settings;
use dosamigos\chartjs\ChartJs;

$marketsHistory = new MarketsHistory();
$markets = Markets::find()->orderBy('market_short_name')->all();
$tick = Settings::getKeyValue('lastTick');
$dataSets = [];

foreach ($markets as $market){

    $id = $market->id;

    $data = $marketsHistory->getHistoryForMarket($id);
    $diff = $marketsHistory->getDiffLastTwoDeltas($id);


    $cap = $marketsHistory->getCapitalizationHistory($id, 100, $market->fkCurrency->id);
    $labels = [];

    for($i = $tick; $i > ($tick - 100) && $i >= 1; $i--){
        $labels[] = $i;
    }

    sort($labels);

    $currentDataset = [
        'label' => $market->market_short_name,
        'backgroundColor' => "rgba(179,181,198,0.2)",
        'borderColor' => "rgba(179,181,198,1)",
        'pointBackgroundColor' => "rgba(179,181,198,1)",
        'pointBorderColor' => "#fff",
        'pointHoverBackgroundColor' => "#fff",
        'pointHoverBorderColor' => "rgba(179,181,198,1)",
        'data' => $cap
    ];

    $dataSets[] = $currentDataset;

    // var_dump($cap);
}

?>

<?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'legend' => false,
    ],

    'data' => [
        'labels' => $labels,
        'datasets' => $dataSets
    ]
]);
?>
