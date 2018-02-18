<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sector')->dropDownList([ 'AGRI' => 'AGRI', 'INDUS' => 'INDUS', 'SERV' => 'SERV', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'POSITIVE' => 'POSITIVE', 'NEGATIVE' => 'NEGATIVE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'priority')->dropDownList([ 'LOW' => 'LOW', 'MEDIUM' => 'MEDIUM', 'HIGH' => 'HIGH', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
