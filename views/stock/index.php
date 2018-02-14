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
                <h5>Актуальный список</h5>
            </div>

            <div class="ibox-content">

                <div class="col-md-6">
                    <?= Html::a('Добавить кампанию', ['create'], ['class' => 'btn btn-success']) ?>
                </div>

                <div class="col-md-3 col-md-offset-3 ">
                    <select class="form-control m-b" name="account">
                        <option>В валюте биржи</option>
                        <option>SGD</option>
                        <option>MP</option>
                        <option>NC</option>
                        <option>GD</option>
                    </select>

                </div>

                <div style="clear:both"></div>
                <hr>





                <?= GridView::widget([

                    'dataProvider' => $dataProvider,

                    'layout' => '{items}<hr>{pager}',

                    'tableOptions' => [
                        'class' => 'table table-hover'
                    ],


                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],


                        'fkMarket' => [
                            'attribute'=>'fk_market',
                            'label' => 'Биржа',
                            'enableSorting'=> true,
                            'format' => 'raw',
                            'value' => function ($data) {
                                $src = $data->fkMarket->fkCurrency->logo;

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
                        'amount',
                        'capitalization' => [
                            'label' => 'Капитализация',
                            'attribute' => 'capitalization',
                            'format' => ['decimal',2],
                            'value' => function ($data) { return $data->capitalization;}
                        ],
                        'sum' => [
                            'label' => 'Цена акции',
                            'attribute' => 'sum',
                            'format' => ['decimal', 2],
                            'value' => function ($data) {
                                return $data->sum;
                            }
                        ],
                        'value' => [
                            'label' => 'Дельта',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if(rand(0,1))
                                    return '<i class="fa fa-level-up" style="color:#1ab394"></i>'.(rand(1, 60)/10).'%';

                                else
                                    return '<i class="fa fa-level-down" style="color:#f8ac59"></i>'.(rand(1, 80)/10).'%';
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
/*
                        ['class' => 'yii\grid\ActionColumn',
                            'header'=>'Действия',
                            'headerOptions' => ['width' => '100'],
                            'template' => '<div class="btn-group">{update}{delete}</div>',
                        'buttons' => [
                            'update' => function ($url,$model) {
                                return '<button class="btn btn-xs btn-white" type="button">'.Html::a('<i class="fa fa-pencil"></i>',$url).'</button>';
                            },
                            'delete' => function ($url,$model,$key) {
                                return '<button class="btn btn-xs btn-danger" type="button">'.Html::a('<i class="fa fa-trash"></i>', $url).'</button>';
                            },
                        ]
                            ]*/
                    ],
                ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
