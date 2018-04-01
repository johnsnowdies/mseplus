<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить';
?>
<div class="news-create">

    <div class="col-lg-6 col-lg-offset-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Создание новости</h5>
            </div>

            <div class="ibox-content">


            <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
            </div>
        </div>
    </div>

</div>
