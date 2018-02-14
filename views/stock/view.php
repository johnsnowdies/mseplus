<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Stock */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Кампании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-view">

<div class="col-lg-6 col-lg-offset-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Информация о Кампании</h5>
                    </div>

                    <div class="ibox-content">


    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Точно хочешь удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fk_market' => [
                'label' => 'Биржа',
                'format' => 'raw',
                'value' => function($data){
                    return "<img src=\"{$data->fkMarket->logo}\">&nbsp;".$data->fkMarket->market_short_name;
                }
            ],
            'company_name',
            
            'amount' => [
                'label' => 'Размещено акций',
                'format' => ['decimal',2],
                'value' => function($data){
                    return $data->capitalization;
                }
            ],

            'capitalization' => [
                'label' => 'Капитализация',
                'format' => ['decimal',2],
                'value' => function($data){
                    return $data->capitalization;
                }
            ],

            'share_price' => [
                'label' => 'Цена акции',
                'format' => ['decimal', 2],
                'value' => function ($data){
                      return $data->share_price;
                }
            ],

            'initial_capitalization' => [
                'label' => 'Установочная капитализация',
                'format' => ['decimal',2],
                'value' => function($data){
                    return $data->initial_capitalization;
                }
            ],
            
            'initial_share_price' => [
                'label' => 'Установочная цена акции',
                'format' => ['decimal', 2],
                'value' => function ($data){
                      return $data->initial_share_price;
                }
            ],
        ],
    ]) ?>
</div>
</div>
</div>
</div>
