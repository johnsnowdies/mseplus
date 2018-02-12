<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Stock */

$this->title = 'Добавить кампанию';
$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
