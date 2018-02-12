<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */

$this->title = 'Обновить: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Markets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="markets-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
