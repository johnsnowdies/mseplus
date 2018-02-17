<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Биржи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Актуальный список</h5>
            </div>

            <div class="ibox-content">

                <div class="col-md-6">
                    <?= Html::a('Добавить биржу', ['create'], ['class' => 'btn btn-success']) ?>
                </div>

                <div style="clear:both"></div>
                <hr>
                <?php Pjax::begin(['id' => 'markets', 'timeout' => false]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}<hr>{pager}',
                    'tableOptions' => [
                        'class' => 'table table-hover'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'logo' => [
                            'label' => 'Лого',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->logo)
                                    return "<img src=\"{$data->logo}\" height=20 width=40>";
                            }
                        ],
                        'fkCurrency' => [
                            'label' => 'Валюта',
                            'value' => function ($data) {
                                return $data->fkCurrency->currency_short_name;
                            }
                        ],
                        'type',
                        'name' => [
                            'label' => 'Название',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return "<a href=\"/markets/view?id={$data->id}\">{$data->name}</a>";
                            }
                        ],
                        'market_short_name',
                        'max_companies',
                        'max_agents',
                        'max_amount',
                        'min_amount',
                        'max_capitalization',
                        'min_capitalization',
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
