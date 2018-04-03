<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MetaNews */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Мета Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-news-create">

    <div class="col-lg-8 col-lg-offset-2">
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
