<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Markets */

$this->title = 'Добавить биржу';
$this->params['breadcrumbs'][] = ['label' => 'Markets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-create">
<div class="col-lg-6 col-lg-offset-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Новая биржа</h5>
            </div>

            <div class="ibox-content">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
    </div>

</div>
