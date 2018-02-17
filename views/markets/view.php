<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Биржи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-view">
    <div class="col-lg-6 col-lg-offset-3">
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
                'value' => function($data){
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
                'value' => function($data){
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
