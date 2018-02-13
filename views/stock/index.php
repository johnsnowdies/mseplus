<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кампании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Актуальный список <small class="m-l-sm">This is custom panel</small></h5>
                    </div>

                    <div class="ibox-content">
                    <p>
        <?= Html::a('Добавить кампанию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fkCurrency' => [
                'label' => 'Валюта',
                'value' => function ($data){
                    return $data->fkMarket->fkCurrency->currency_short_name;
                }
            ],

            'fkMarket' => [
                'label' => 'Биржа',
                'format' => 'raw',
                'value' => function ($data){
                    $src = $data->fkMarket->fkCurrency->logo;

                    return "<img src=\"{$src}\" height=20 width=40 > &nbsp;". $data->fkMarket->market_short_name;
                }
            ],
            'company_name',
            'amount',
            'capitalization',
            'sum' => [
                'label' => 'Цена акции',
                'format' => ['decimal', 2],
                'value' => function ($data){
                    return $data->sum;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                    </div>
                    <div class="ibox-footer">
                        <span class="pull-right">
                          The righ side of the footer
                    </span>
                        This is simple footer example
                    </div>
                </div>
            </div>

    
</div>
