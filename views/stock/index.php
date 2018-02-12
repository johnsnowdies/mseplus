<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кампании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Stock', ['create'], ['class' => 'btn btn-success']) ?>
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
                'value' => function ($data){
                    return $data->fkMarket->market_short_name;
                }
            ],
            'company_name',
            'amount',
            'capitalization',
            'sum',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
