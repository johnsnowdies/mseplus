<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Биржи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Markets', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fkCurrency' => [
                'label' => 'Валюта',
                'value' => function ($data){
                    return $data->fkCurrency->currency_short_name;
                }
            ],
            'type',
            'name',
            'market_short_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
