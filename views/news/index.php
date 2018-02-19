<?php

use app\models\News;
use app\models\Stock;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Актуальный список</h5>
            </div>

            <div class="ibox-content">
                <div class="col-md-6">
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            <div style="clear:both"></div>
            <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'maxButtonCount' => 25,    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => '{items}<hr><center>{pager}</center>',
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
    'class' => 'kartik\grid\ExpandRowColumn',
    'width' => '50px',
    'value' => function ($model, $key, $index, $column) {
        return GridView::ROW_COLLAPSED;
    },
    'detail' => function ($model, $key, $index, $column) {
        return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
    },
    'headerOptions' => ['class' => 'kartik-sheet-style'],
    'expandOneOnly' => true
],
            'tick',
            'fkMarket' => [
                'attribute' => 'fk_market',
                'label' => 'Биржа',
                'enableSorting' => true,
                'format' => 'raw',
                'value' => function ($data) {
                    $src = $data->fkMarket->logo;
                    return "<img src=\"{$src}\" height=20 width=40 > &nbsp;" . $data->fkMarket->market_short_name;
                }
            ],
            'title',

            'sector' => [
                'label' => 'Сектор',
                'attribute' => 'sector',
                'format' => 'raw',
                'value' => function($data){
                    if ($data->sector == Stock::SECTOR_AGRICULTURAL)
                        return "<span class=\"badge badge-warning\">Агрокультурный</span>";

                    if ($data->sector == Stock::SECTOR_INDUSTRIAL)
                        return "<span class=\"badge badge-danger\">Индустриальный</span>";

                    if ($data->sector == Stock::SECTOR_SERVICE)
                        return "<span class=\"badge badge-primary\">Услуг</span>";
                }
            ],
            'type' => [
                'label' => 'Оттенок',
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data){
                    if ($data->type == News::TYPE_NEGATIVE)
                        return "<span class=\"badge badge-danger\">&ndash;</span>";

                    if ($data->type == News::TYPE_POSITIVE)
                        return "<span class=\"badge badge-primary\">+</span>";


                }
            ],

            'priority' => [
                'label' => 'Влияние',
                'attribute' => 'priority',
                'format' => 'raw',
                'value' => function($data){
                    if ($data->priority == News::PRIORITY_LOW)
                        return "<span class=\"badge badge-plain\">Низкое</span>";

                    if ($data->priority == News::PRIORITY_MEDIUM)
                        return "<span class=\"badge badge-warning\">Средние</span>";

                    if ($data->priority == News::PRIORITY_HIGH)
                        return "<span class=\"badge badge-danger\">Высокое</span>";


                }
            ],

        ],
    ]); ?>
            </div>
        </div>
    </div>

</div>
