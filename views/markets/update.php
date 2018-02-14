<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */

$this->title = 'Обновить: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Биржи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="markets-update">
<div class="col-lg-6 col-lg-offset-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Редактирование</h5>
            </div>

            <div class="ibox-content">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>

</div>
