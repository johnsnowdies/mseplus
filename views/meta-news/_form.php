<?php

use app\models\Markets;
use app\models\Stock;

use dosamigos\multiselect\MultiSelect;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\MetaNews */
/* @var $form yii\widgets\ActiveForm */
?>

<script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>


<script type="text/javascript">
    var news = [];
    var counter = 0;
    function deleteRow(c){

        $("#row-"+c).remove();
        news.splice(c,1);
        counter--;
        $('#dataNews').attr('value', JSON.stringify(news));

    }

    function getMarketName(val) {
        return $('#iMarket option[value="'+val+'"]').text();


    }

    function getPriorityValue(val) {
        if (val == 'HIGH')
            return 'Высокий';

        if (val == 'MEDIUM')
            return 'Средний';

        if (val == 'LOW')
            return 'Низкий';


    }

    function getTypeValue(val) {
        if (val == 'POSITIVE')
            return 'Положительный';

        if (val == 'NEGATIVE')
            return 'Отрицательный'

    }

    $(document).ready(function () {





        $('#addNews').click(function () {

            var market = $('#iMarket').val();
            var priority = $('#iPriority').val();
            var type = $('#iType').val();
            var ttl = $('#iTtl').val();


            var current = {
                "market": market,
                "priority": priority,
                "type": type,
                "ttl": ttl
            };







            $( "#newsOutput" ).append( "<tr id=\"row-"+counter+"\"><td><img src=\"/resource/img/" + getMarketName(market)  +".png  \"> "+ getMarketName(market) +"</td> <td>"+ getPriorityValue(priority) +"</td><td>" + getTypeValue(type)+"</td><td>"+ttl+"</td><td><div class=\"btn btn-xs btn-circle btn-danger\" onclick=\"deleteRow("+counter+")\"  counter=\\\"row-\"+counter+\"\\\" >-</div></td><tr>" );

            news.push(current);
            console.log(current);

            counter++;

            $('#dataNews').attr('value', JSON.stringify(news));

        });

    });

</script>


<div class="meta-news-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'titl')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'startTick')->textInput() ?>
        </div>
    </div>





    <?php
    echo MultiSelect::widget([
        'id'=>"iSector",
        "options" => ['multiple'=>"multiple"], // for the actual multiselect
        'data' => [  'AGRI' => 'Агрокультурный',
            'INDUS' => 'Индустриальный',
            'SERV' => 'Услуг',], // data as array

        'name' => 'MetaNews[dataSectors]', // name for the form
        "clientOptions" =>
            [
                "includeSelectAllOption" => true,
                'numberDisplayed' => 2
            ],
    ]);
    ?>



    <?= $form->field($model,'dataNews')->hiddenInput(['id' => 'dataNews']) ?>




        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th>Биржа</th>
                <th>Приоритет</th>
                <th>Оттенок</th>
                <th>Время жизни</th>
                <th></th>
                </tr>
            </thead>
             <tbody id="newsOutput">

            </tbody>

        </table>


    <div class="row">



        <div class="col-sm-2">
            <?= $form->field($model, 'tmpMarket')->label('Биржа')->dropDownList(
                Markets::getMarketsArray(),
                ['id' => 'iMarket']
            ) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'tmpPriority')->label('Приоритет')->dropDownList(
                    ['LOW' => 'Низкий', 'MEDIUM' => 'Средний', 'HIGH' => 'Высокий'],
                    ['id' => 'iPriority']) ?>

        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'tmpType')->label('Оттенок')->dropDownList(['POSITIVE' => 'Положительный', 'NEGATIVE' => 'Отрицателный',],
                ['id' => 'iType']) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'tmpTtl')->label('TTL')->textInput(['id' => 'iTtl']) ?>
        </div>

        <div class="col-sm-2">
            <div class="btn btn-lg btn-primary" id="addNews">+</div>

        </div>


    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
