<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_currency')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'INTERNAL' => 'INTERNAL', 'EXTERNAL' => 'EXTERNAL', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'market_short_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
