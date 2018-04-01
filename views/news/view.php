<?php

use app\models\News;
use app\models\Stock;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <div class="col-lg-6 col-lg-offset-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Информация о новости</h5>
            </div>

            <div class="ibox-content">


            <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Точно удаляем новость?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
/*
            'fkMarket' => [
                'attribute' => 'fk_market',
                'label' => 'Биржа',
                'enableSorting' => true,
                'format' => 'raw',
                'value' => function ($data) {
                    $src = $data->getFkMarket()->logo;
                    return "<img src=\"{$src}\" height=20 width=40 > &nbsp;" . $data->fkMarket->market_short_name;
                }
            ],*/
            'title' => [
                'label' => 'Заголовок',
                'format' => 'raw',
                'value' => function($data) {
                    return "<a href=\"/news/view?id={$data->id}\">{$data->title}</a>";
                }

            ],

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

            'text:ntext',

        ],
    ]) ?>

</div>
