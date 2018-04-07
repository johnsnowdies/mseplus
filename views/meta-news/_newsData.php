
<?php
/**
 * Created by PhpStorm.
 * User: eslider
 * Date: 07.04.18
 * Time: 20:24
 */



use app\models\News;
use app\models\Stock;
use kartik\grid\GridView;


/* @var $model app\models\News */


$newsIds = unserialize($model);


$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => News::find()->select(['tick','ttl','fk_market','type','priority'])->where(['in','id',$newsIds])->distinct()
]);

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,

    'layout' => '{items}<hr><center>{pager}</center>',
    'tableOptions' => [
        'class' => 'table table-hover'
    ],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        'tick' => [
            'label' => 'Начало',
            'value' => function($data){
                return $data->tick;
            }
        ],

        'ttl' => [
            'label' => 'Окончание',
            'value' => function($data){
                return $data->tick + $data->ttl;
            }
        ],

        'fkMarket' => [
            'attribute' => 'fk_market',
            'label' => 'Биржа',
            'enableSorting' => true,
            'format' => 'raw',
            'value' => function ($data) {
                $src = $data->fkMarket->logo;
                return "<img src=\"{$src}\" height=20 width=40 > &nbsp;" . $data->fkMarket->market_short_name;
            }
        ],


        'type' => [
            'label' => 'Оттенок',
            'attribute' => 'type',
            'format' => 'raw',
            'value' => function($data){
                if ($data->type == News::TYPE_NEGATIVE)
                    return "<span class=\"badge badge-danger\">&ndash;</span>";

                if ($data->type == News::TYPE_POSITIVE)
                    return "<span class=\"badge badge-primary\">+</span>";


            }
        ],

        'priority' => [
            'label' => 'Влияние',
            'attribute' => 'priority',
            'format' => 'raw',
            'value' => function($data){
                if ($data->priority == News::PRIORITY_LOW)
                    return "<span class=\"badge badge-plain\">Низкое</span>";

                if ($data->priority == News::PRIORITY_MEDIUM)
                    return "<span class=\"badge badge-warning\">Средние</span>";

                if ($data->priority == News::PRIORITY_HIGH)
                    return "<span class=\"badge badge-danger\">Высокое</span>";


            }
        ],

    ],
]); ?>