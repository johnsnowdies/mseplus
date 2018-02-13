<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Валюты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currencies-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Currencies', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'country',
            'currency',
            'currency_short_name',
            'max_companies',
            'max_agents',
            'logo' => [
                'label' => 'Лого',
                'format' => 'raw',
                'value' => function($data){
                    if ($data->logo)
                    return "<img src=\"{$data->logo}\" height=20 width=40>";
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>