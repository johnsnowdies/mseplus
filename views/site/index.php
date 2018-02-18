<?php

/* @var $this yii\web\View */
/* @var $stockDataProvider yii\data\ActiveDataProvider */
/* @var $newsDataProvider yii\data\ActiveDataProvider */

$news = $newsDataProvider->query->orderBy(['id' => SORT_DESC])->limit(5)->all();

use app\models\Stock;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Главная: состояние биржи';
?>
<div class="site-index">

    

    <div class="row">
        <div class="col-lg-5">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-shield fa-4x"></i>
                    <h1 class="m-xs">SGD</h1>
                    <h3 class="font-bold no-margins">
                        Главная резервная валюта вчерашнего дня торгов
                    </h3>
                    <small>1 Universal Unit = 1 Standard Gold Dragon</small>
                </div>
            </div>

            <table class="table">
                <tbody>
                <tr>
                    <td>
                        <button type="button" class="btn btn-danger m-r-sm">3</button>
                        Oбанкротилось
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary m-r-sm">2</button>
                        IPO
                    </td>
                    <td>
                        <button type="button" class="btn btn-info m-r-sm">10</button>
                        Новостей
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-success m-r-sm">1</button>
                        Такт
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Сводный курс валют</h5>

                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Валюта</th>
                            <th>Золото (1gr)</th>
                            <th>Платина (1gr)</th>
                            <th>Мифрил (1gr)</th>
                            <th>10 Ментан энергии</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>SGD</td>
                            <td>1.12</td>
                            <td>2.19</td>
                            <td>3.29</td>
                            <td>0.1</td>

                        </tr>

                        <tr>
                            <td>MP</td>
                            <td>11.22</td>
                            <td>21.90</td>
                            <td>32.290</td>
                            <td>1 <span class="badge badge-info"><i class="fa fa-lock"></i> </span></td>

                        </tr>
                        <tr>
                            <td>NC</td>
                            <td>4.12</td>
                            <td>3.19</td>
                            <td>6.29</td>
                            <td>0.5</td>

                        </tr>
                        <tr>
                            <td>DR</td>
                            <td>0.96</td>
                            <td>1.19</td>
                            <td>2.29</td>
                            <td>0.21</td>

                        </tr>

                        <tr>
                            <td>GD</td>
                            <td>116.96</td>
                            <td>211.19</td>
                            <td>341.29</td>
                            <td>15.21</td>

                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div id="vertical-timeline" class="vertical-container light-timeline">

                <?php foreach ($news as $item):?>

                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon navy-bg">
                        <i class="fa fa-briefcase"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2><?=$item->title?></h2>
                        <p><?=$item->text?></p>

                        <span class="vertical-date">Такт #<?=$item->tick?></span>
                    </div>
                </div>

                <?php endforeach;?>
            </div>
            <div style="text-align: center;margin-bottom: 25px;">
                <a href="#">Все новости</a>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Рейтинг компаний</h5>
                </div>

                <div class="ibox-content">
                    <?php Pjax::begin();?>
                    <?= GridView::widget([
                        'dataProvider' => $stockDataProvider,
                        'filterModel' => new app\models\StockSearch(),
                        'layout' => '{items}',
                        'tableOptions' => [
                            'class' => 'table table-hover'
                        ],
                        'columns' => [
                            'fkMarket' => [
                                'headerOptions' => ['style' => 'width:140px'],
                                'attribute'=>'fk_market',
                                'label' => 'Биржа',
                                'enableSorting'=> true,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $src = $data->fkMarket->logo;
                                    return "<img src=\"{$src}\" height=20 width=40 > &nbsp;" . $data->fkMarket->market_short_name;
                                }
                            ],

                            'company_name' => [
                                'attribute' => 'company_name',
                                'label' => 'Название кампании',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return "<a href=\"/stock/view?id={$data->id}\">{$data->company_name}</a>";
                                }
                            ],

                            'capitalization' => [
                                'label' => 'Капитализация',
                                'attribute' => 'capitalization',
                                'format' => ['decimal', 2],
                                'value' => function ($data) {
                                    return $data->capitalization;
                                }
                            ],

                            'value' => [
                                'label' => 'DELTA',
                                'headerOptions' => ['style' => 'width:90px'],
                                'format' => 'raw',
                                'value' => function ($data) {
    
                                    if($data->behavior == 'GROWTH')
                                        return '<i class="fa fa-level-up" style="color:#1ab394"></i>'.Yii::$app->formatter->format($data->delta,['decimal', 2]).'%';
                                    else
                                        return '<i class="fa fa-level-down" style="color:#ed5565"></i>'.Yii::$app->formatter->format($data->delta,['decimal', 2]).'%';
                                }
                            ],

                            'fkCurrency' => [

                                'attribute' => 'fk_currency',
                                'label' => 'Валюта',
                                'enableSorting' => true,
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->fkMarket->fkCurrency->currency_short_name;
                                }
                            ],

                        ],
                    ]); ?>
                    <?php Pjax::end();?>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5 class="m-b-md">Повышение</h5>
                    <h2 class="text-navy">
                        <i class="fa fa-play fa-rotate-270"></i> MSUEE
                    </h2>
                    <small>Moon and Star union External Exchange</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content ">
                    <h5 class="m-b-md">Повышение</h5>
                    <h2 class="text-navy">
                        <i class="fa fa-play fa-rotate-270"></i> ERES
                    </h2>
                    <small>Enerian Republic Exchange Service</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5 class="m-b-md">Спад</h5>
                    <h2 class="text-danger">
                        <i class="fa fa-play fa-rotate-90"></i> NSES
                    </h2>
                    <small>Nova System External Stock</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5 class="m-b-md">Спад</h5>
                    <h2 class="text-danger">
                        <i class="fa fa-play fa-rotate-90"></i> GSCOM
                    </h2>
                    <small>Glory Shining Cat Overlord Market</small>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>MSUEE за 24ч</h5>
                    <h2>198 009</h2>
                    <?= \machour\sparkline\Sparkline::widget([
                        'clientOptions' => [
                            'type' => 'line',
                            'height' => 60,
                            'width' => '100%',
                            'lineColor' => '#1ab394',
                            'fillColor' => '#ffffff'
                        ],
                        'data' => [34, 43, 43, 35, 44, 32, 44, 52]
                    ]); ?>

                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>ERES за 24ч</h5>
                    <h2>65 000</h2>
                    <?= \machour\sparkline\Sparkline::widget([
                        'clientOptions' => [
                            'type' => 'line',
                            'height' => 60,
                            'width' => '100%',
                            'lineColor' => '#1ab394',
                            'fillColor' => '#ffffff'
                        ],
                        'data' => [24, 43, 43, 55, 44, 62, 44, 72]
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>NSES</h5>
                    <h2>680 900</h2>
                    <?= \machour\sparkline\Sparkline::widget([
                        'clientOptions' => [
                            'type' => 'line',
                            'height' => 60,
                            'width' => '100%',
                            'lineColor' => '#ed5565',
                            'fillColor' => '#ffffff'
                        ],
                        'data' => [74, 43, 23, 55, 54, 32, 24, 12]
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>GSCOM</h5>
                    <h2>450 000</h2>
                    <?= \machour\sparkline\Sparkline::widget([
                        'clientOptions' => [
                            'type' => 'line',
                            'height' => 60,
                            'width' => '100%',
                            'lineColor' => '#ed5565',
                            'fillColor' => '#ffffff'
                        ],
                        'data' => [24, 43, 33, 55, 64, 72, 44, 22]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>