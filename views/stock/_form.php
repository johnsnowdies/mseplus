<?php

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

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'capitalization')->textInput() ?>
    <?= $form->field($model, 'share_price')->textInput() ?>
    <?= $form->field($model, 'initial_capitalization')->textInput() ?>
    <?= $form->field($model, 'initial_share_price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
