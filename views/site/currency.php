<?php

/* @var $this yii\web\View */
/* @var $stockDataProvider yii\data\ActiveDataProvider */
/* @var $newsDataProvider yii\data\ActiveDataProvider */


$this->title = 'Главная: состояние биржи';
?>
<div class="site-index">

    <?php
    //$marktesData = \app\models\MarketsDelta::find()->all();
    $marketsHistory = new \app\models\MarketsHistory();
    $ratesService = new \app\models\RatesHistory();

    $history = $ratesService->getLastTicksHistory();

    print_r($history);

    ?>



</div>