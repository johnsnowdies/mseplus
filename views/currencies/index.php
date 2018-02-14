<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Валюты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currencies-index">
<div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Актуальный список</h5>
            </div>

            <div class="ibox-content">

    

      <div class="col-md-6">
        <?= Html::a('Добавить валюту', ['create'], ['class' => 'btn btn-success']) ?>
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
            'currency' => [
                'label' => 'Валюта',
                'format' => 'raw',
                'value' => function ($data){
                    return "<a href=\"/currencies/view?id={$data->id}\">{$data->currency}</a>";
                }
            ],
            'country',
            
            'currency_short_name',
            
        ],
    ]); ?>
    </div>
    </div>
</div>
