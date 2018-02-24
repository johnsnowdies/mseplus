<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = 'Обновить: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="news-update">

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

</div>
