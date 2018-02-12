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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
