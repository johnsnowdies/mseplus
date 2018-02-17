<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Currencies;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markets-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'fk_currency')->dropDownList(
            Currencies::getCurrencyArray()
    ) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'INTERNAL' => 'INTERNAL', 'EXTERNAL' => 'EXTERNAL', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_companies')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'max_agents')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'max_amount')->textInput() ?>
        <?= $form->field($model, 'min_amount')->textInput() ?>
        <?= $form->field($model, 'max_capitalization')->textInput() ?>
        <?= $form->field($model, 'min_capitalization')->textInput() ?>

    <?= $form->field($model, 'rate_agri')->textInput() ?>
    <?= $form->field($model, 'rate_indus')->textInput() ?>
    <?= $form->field($model, 'rate_serv')->textInput() ?>



    <?= $form->field($model, 'market_short_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
