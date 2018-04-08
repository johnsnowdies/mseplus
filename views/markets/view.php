<?php

use app\models\MarketsHistory;
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Биржи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-view"><!--
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Просмотр</h5>
            </div>

            <div class="ibox-content">
                <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>


                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'fk_currency' => [
                            'label' => 'Валюта',
                            'value' => function ($data) {
                                return $data->fkCurrency->currency_short_name;
                            }
                        ],
                        'type',
                        'max_companies',
                        'max_agents',
                        'name',
                        'market_short_name',
                        'rate_agri' => [
                            'label' => 'A/I/S',
                            'value' => function ($data) {
                                return "{$data->rate_agri}/{$data->rate_indus}/{$data->rate_serv}";
                            }
                        ],
                        'max_amount',
                        'min_amount',
                        'max_capitalization',
                        'min_capitalization',

                    ],
                ]) ?>

            </div>
        </div>
    </div>
    -->
    <div class="col-lg-12">
        <div class="ibox-title">
            <h5>Капитализация</h5>
        </div>

        <div class="ibox-content">
        <?php
        $marketsHistory = new MarketsHistory();
        $market = $model;
        $id = $model->id;

        $data = $marketsHistory->getHistoryForMarket($id);
        $diff = $marketsHistory->getDiffLastTwoDeltas($id);
        $tick = \app\models\Settings::getKeyValue('lastTick');


        $cap = $marketsHistory->getCapitalizationHistoryInFiat($id,100,$market->fkCurrency->id);

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


        $cap2 = $marketsHistory->getCapitalizationHistory($id,100,$market->fkCurrency->id);

        $currentDataset2 = [
            'label' => $market->market_short_name,
            'backgroundColor' => "rgba(179,181,198,0.2)",
            'borderColor' => "rgba(179,181,198,1)",
            'pointBackgroundColor' => "rgba(179,181,198,1)",
            'pointBorderColor' => "#fff",
            'pointHoverBackgroundColor' => "#fff",
            'pointHoverBorderColor' => "rgba(179,181,198,1)",
            'data' => $cap2
        ];

        $dataSets[] = $currentDataset;

        // var_dump($cap);

        $labels = [];

        for($i = $tick; $i > ($tick - 100) && $i >= 1; $i--){
            $labels[] = $i;
        }

        sort($labels);




        $color = '';

        if ($diff)
            $color = '#1ab394';
        else
            $color = '#ed5565';

        ?>


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

            <h3>В валюте биржи</h3>
                    <?= ChartJs::widget([
                        'type' => 'line',
                        'options' => [
                            'legend' => false,
                        ],

                        'data' => [
                            'labels' =>$labels,
                            'datasets' => [$currentDataset

                            ]
                        ]
                    ]);
                    ?>
<hr>
            <h3>В Exchange Units</h3>
            <?= ChartJs::widget([
                'type' => 'line',
                'options' => [
                    'legend' => false,
                ],

                'data' => [
                    'labels' =>$labels,
                    'datasets' => [$currentDataset2

                    ]
                ]
            ]);
            ?>
        </div>



    </div>


</div>