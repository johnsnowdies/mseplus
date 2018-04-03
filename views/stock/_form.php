<?php

use app\models\Stock;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Markets;

/* @var $this yii\web\View */
/* @var $model app\models\Stock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_market')->dropDownList(
            Markets::getMarketsArray()
    ) ?>

    <?= $form->field($model, 'sector')->dropDownList([
        Stock::SECTOR_AGRICULTURAL => 'Агрокультурный',
        Stock::SECTOR_INDUSTRIAL => 'Промышленый',
        Stock::SECTOR_SERVICE => 'Услуги'
        ]) ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'capitalization')->textInput() ?>
    <?= $form->field($model, 'share_price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
