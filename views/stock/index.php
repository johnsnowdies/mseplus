<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Rates;
use yii\widgets\Pjax;

$session = Yii::$app->session;
$selectedCurrency = $session->get('currency');
$rate = new Rates();
$exchangeRates = $rate->getSystemRates();


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кампании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Актуальный список</h5>
            </div>

            <div class="ibox-content">
                <div class="col-md-6">
                    <?= Html::a('Добавить кампанию', ['create'], ['class' => 'btn btn-success']) ?>
                </div>

                <div class="col-md-3 col-md-offset-3 ">
                    <select class="form-control m-b" id="stock-currency">
                        <option value="nodata" <?=(!$selectedCurrency)?'selected':''?>>В валюте биржи</option>
                        <option <?=($selectedCurrency == 'SGD')?'selected':''?>>SGD</option>
                        <option <?=($selectedCurrency == 'DR')?'selected':''?>>DR</option>
                        <option <?=($selectedCurrency == 'MP')?'selected':''?>>MP</option>
                        <option <?=($selectedCurrency == 'NC')?'selected':''?>>NC</option>
                        <option <?=($selectedCurrency == 'GD')?'selected':''?>>GD</option>
                    </select>

                </div>

                <div style="clear:both"></div>
                <hr>
                <?php Pjax::begin(['id' => 'stocks', 'timeout' => false]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}<hr>{pager}',
                    'tableOptions' => [
                        'class' => 'table table-hover'
                    ],

                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'fkMarket' => [
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
                        'amount',
                        'capitalization' => [
                            'label' => 'Капитализация',
                            'attribute' => 'capitalization',
                            'format' => ['decimal',2],
                            'value' => function ($data) use (&$selectedCurrency, &$exchangeRates) { 
                                $result = $data->capitalization;
                                $currency =  $data->fkMarket->fkCurrency->currency_short_name;
                                if ($selectedCurrency && $selectedCurrency!=$currency)
                                    $result /= ($exchangeRates[$selectedCurrency][$currency]);
                                
                                return $result;
                            }
                        ],
                        'share_price' => [
                            'label' => 'Цена акции',
                            'attribute' => 'share_price',
                            'format' => ['decimal', 2],
                            'value' => function ($data) use (&$selectedCurrency, &$exchangeRates) {
                                $result = $data->share_price;
                                $currency =  $data->fkMarket->fkCurrency->currency_short_name;
                                if ($selectedCurrency && $selectedCurrency!=$currency)
                                $result /= ($exchangeRates[$selectedCurrency][$currency]);

                                return $result;
                            }
                        ],
                        'value' => [
                            'label' => 'Дельта',
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
                            'value' => function ($data) use (&$selectedCurrency) {
                                if ($selectedCurrency)
                                    return $selectedCurrency;
                                else
                                    return $data->fkMarket->fkCurrency->currency_short_name;
                            }
                        ],

                    ],
                ]); ?>
                <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
