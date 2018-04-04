<?php

/* @var $this yii\web\View */
/* @var $stockDataProvider yii\data\ActiveDataProvider */
/* @var $newsDataProvider yii\data\ActiveDataProvider */

$news = $newsDataProvider->query->orderBy(['id' => SORT_DESC])->limit(5)->all();

use app\models\Markets;
use app\models\MarketsHistory;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Stock;
use dosamigos\chartjs\ChartJs;



$this->title = 'Главная: состояние биржи';
?>
<div class="site-index">

    <?php

    $marketsHistory = new MarketsHistory();
    $markets = Markets::find()->orderBy('market_short_name')->all();

    $dataSets = [];

    $ratesService = new \app\models\RatesHistory();
    $tick = \app\models\Settings::getKeyValue('lastTick');

    $ratesHist = $ratesService->getGraphData();



    ?>

    <div class="row">
        <?php foreach ($ratesHist as $rate => $rateValue):?>

            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">

                        <h2 class="">
                            <?= $rate ?>
                        </h2>

                        <?= ChartJs::widget([
                            'type' => 'line',
                            'options' => [
                                'legend' => false,
                            ],

                            'data' => [
                                'labels' => [$tick-10,$tick-9,$tick-8,$tick-7,$tick-6,$tick-5,$tick-4,$tick-3,$tick-2,$tick-1,$tick],
                                'datasets' => [
                                    [
                                        'label' => $rate,
                                        'backgroundColor' => "rgba(179,181,198,0.2)",
                                        'borderColor' => "rgba(179,181,198,1)",
                                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                        'data' => $rateValue
                                    ]

                                ]
                            ]
                        ]);
                        ?>





                    </div>
                </div>
            </div>



        <?php endforeach;?>
    </div>

    <div class="row">
        <?php foreach ($markets as $market):

            $id = $market->id;

            $data = $marketsHistory->getHistoryForMarket($id);
            $diff = $marketsHistory->getDiffLastTwoDeltas($id);


            $cap = $marketsHistory->getCapitalizationHistory($id,10,$market->fkCurrency->id);

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

            $color = '';

            if ($diff)
                $color = '#1ab394';
            else
                $color = '#ed5565';

            ?>

            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">

                        <h2 class="<?=($diff)? 'text-navy': 'text-danger' ?>">

                            <?php if($diff):?>
                                <i class="fa fa-play fa-rotate-270"></i>
                            <?php endif; ?>

                            <?php if(!$diff):?>
                                <i class="fa fa-play fa-rotate-90"></i>
                            <?php endif; ?>


                            <?=$market->market_short_name?>
                            <?= \machour\sparkline\Sparkline::widget([
                                'clientOptions' => [
                                    'type' => 'bar',
                                    'height' => 20,
                                    'width' => '100%',
                                    'lineColor' => $color,
                                    'fillColor' => '#ffffff',
                                    'barColor' => '#1ab394',
                                    'negBarColor' => '#ed5565',
                                    //'chartRangeMin' => -20,
                                    //'chartRangeMax' => 20,

                                    //'normalRangeMin' => -10,
                                    //'normalRangeMax' => 10,
                                    'drawNormalOnTop' => true,
                                    'normalRangeColor' => '#eee'
                                ],
                                'data' => $data
                            ]); ?>

                            <br>


                            <?php if(count($data) > 1):?>
                                <small><?=$data[count($data)-1]?>%</small>
                            <?php endif;?>
                        </h2>

                        <?= ChartJs::widget([
                            'type' => 'line',
                            'options' => [
                                'legend' => false,
                            ],

                            'data' => [
                                'labels' => [$tick-10,$tick-9,$tick-8,$tick-7,$tick-6,$tick-5,$tick-4,$tick-3,$tick-2,$tick-1,$tick],
                                'datasets' => [$currentDataset

                                ]
                            ]
                        ]);
                        ?>



                    </div>
                </div>
            </div>

        <?php endforeach;?>
    </div>





<!--
    <div class="row">
        <div class="col-lg-5">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-shield fa-4x"></i>
                    <h1 class="m-xs">SGD</h1>
                    <h3 class="font-bold no-margins">
                        Главная резервная валюта вчерашнего дня торгов
                    </h3>
                    <small>1 Universal Unit = 1 Standard Gold Dragon</small>
                </div>
            </div>

            <table class="table">
                <tbody>
                <tr>
                    <td>
                        <button type="button" class="btn btn-danger m-r-sm">3</button>
                        Oбанкротилось
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary m-r-sm">2</button>
                        IPO
                    </td>
                    <td>
                        <button type="button" class="btn btn-info m-r-sm">10</button>
                        Новостей
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-success m-r-sm">1</button>
                        Такт
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Сводный курс валют</h5>

                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Валюта</th>
                            <th>Золото (1gr)</th>
                            <th>Платина (1gr)</th>
                            <th>Мифрил (1gr)</th>
                            <th>10 Ментан энергии</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>SGD</td>
                            <td>1.12</td>
                            <td>2.19</td>
                            <td>3.29</td>
                            <td>0.1</td>

                        </tr>

                        <tr>
                            <td>MP</td>
                            <td>11.22</td>
                            <td>21.90</td>
                            <td>32.290</td>
                            <td>1 <span class="badge badge-info"><i class="fa fa-lock"></i> </span></td>

                        </tr>
                        <tr>
                            <td>NC</td>
                            <td>4.12</td>
                            <td>3.19</td>
                            <td>6.29</td>
                            <td>0.5</td>

                        </tr>
                        <tr>
                            <td>DR</td>
                            <td>0.96</td>
                            <td>1.19</td>
                            <td>2.29</td>
                            <td>0.21</td>

                        </tr>

                        <tr>
                            <td>GD</td>
                            <td>116.96</td>
                            <td>211.19</td>
                            <td>341.29</td>
                            <td>15.21</td>

                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
-->
    <div class="row">
        <div class="col-lg-5">
            <div id="vertical-timeline" class="vertical-container light-timeline">

                <?php foreach ($news as $item):?>

                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon navy-bg">
                        <i class="fa fa-briefcase"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2><?=$item->title?></h2>
                        <p><?=$item->text?></p>

                        <span class="vertical-date">Такт #<?=$item->tick?></span>
                    </div>
                </div>

                <?php endforeach;?>
            </div>
            <div style="text-align: center;margin-bottom: 25px;">
                <a href="#">Все новости</a>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Рейтинг компаний</h5>
                </div>

                <div class="ibox-content">
                    <?php Pjax::begin();?>
                    <?= GridView::widget([
                        'dataProvider' => $stockDataProvider,
                        'layout' => '{items}',
                        'tableOptions' => [
                            'class' => 'table table-hover'
                        ],
                        'columns' => [
                            'fkMarket' => [
                                'headerOptions' => ['style' => 'width:140px'],
                                'attribute'=>'fk_market',
                                'label' => 'Биржа',
                                'enableSorting'=> true,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $src = $data->fkMarket->logo;
                                    return "<img src=\"{$src}\" height=20 width=40 > &nbsp;" . $data->fkMarket->market_short_name;
                                }
                            ],

                            'company_name' => [
                                'attribute' => 'company_name',
                                'label' => 'Название кампании',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return "<a href=\"/stock/view?id={$data->id}\">{$data->company_name}</a>";
                                }
                            ],

                            'capitalization' => [
                                'label' => 'Капитализация',
                                'attribute' => 'capitalization',
                                'format' => ['decimal', 2],
                                'value' => function ($data) {
                                    return $data->capitalization;
                                }
                            ],

                            'value' => [
                                'label' => 'DELTA',
                                'headerOptions' => ['style' => 'width:90px'],
                                'format' => 'raw',
                                'value' => function ($data) {
    
                                    if($data->behavior == 'GROWTH')
                                        return '<i class="fa fa-level-up" style="color:#1ab394"></i>'.Yii::$app->formatter->format($data->delta,['decimal', 2]).'%';
                                    else
                                        return '<i class="fa fa-level-down" style="color:#ed5565"></i>'.Yii::$app->formatter->format($data->delta,['decimal', 2]).'%';
                                }
                            ],

                            'fkCurrency' => [

                                'attribute' => 'fk_currency',
                                'label' => 'Валюта',
                                'enableSorting' => true,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->fkMarket->fkCurrency->currency_short_name;
                                }
                            ],

                        ],
                    ]); ?>
                    <?php Pjax::end();?>
                </div>
            </div>

        </div>
    </div>



</div>