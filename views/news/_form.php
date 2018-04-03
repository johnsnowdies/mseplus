<?php

use app\models\Markets;
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

    <?= $form->field($model, 'fk_market')->dropDownList(
        Markets::getMarketsArray()
    ) ?>

    <?= $form->field($model, 'sector')->dropDownList(
            [
                'AGRI' => 'Агрокультурный',
                'INDUS' => 'Индустриальный',
                'SERV' => 'Услуг',
            ],
            [
                'prompt' => ''
            ]) ?>

    <?= $form->field($model, 'ttl')->textInput() ?>



    <?= $form->field($model, 'type')->dropDownList([ 'POSITIVE' => '+', 'NEGATIVE' => '-', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'priority')->dropDownList([ 'LOW' => 'Низкое', 'MEDIUM' => 'Среднее', 'HIGH' => 'Высокое', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
