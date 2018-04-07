<?php

use app\models\News;
use app\models\Stock;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-news-index">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Актуальный список</h5>
            </div>

            <div class="ibox-content">
                <div class="col-md-6">
                    <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div style="clear:both"></div>
                <hr>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'maxButtonCount' => 25,    // Set maximum number of page buttons that can be displayed
                    ],
                    'layout' => '{items}<hr><center>{pager}</center>',
                    'tableOptions' => [
                        'class' => 'table table-hover'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'titl',
                        'sectors' => [
                            'label' => 'Сектора',
                            'format' => 'raw',
                            'value' => function ($data) {
                                $sectors = unserialize($data->sectors);
                                $output = "";
                                $glue = "";


                                foreach ($sectors as $sector) {
                                    if ($sector == Stock::SECTOR_AGRICULTURAL)
                                        $output .= "{$glue}<span class=\"badge badge-warning\">Агрокультурный</span>";

                                    if ($sector == Stock::SECTOR_INDUSTRIAL)
                                        $output .= "{$glue}<span class=\"badge badge-danger\">Индустриальный</span>";

                                    if ($sector == Stock::SECTOR_SERVICE)
                                        $output .= "{$glue}<span class=\"badge badge-primary\">Услуг</span>";

                                    $glue = "&nbsp;";
                                }


                                return $output;
                            }
                        ],

                        'news' => [
                            'label' => 'Данные',
                            'format' => 'raw',
                            'value' => function ($data) {

                                return $this->render('_newsData', [
                                    'model' => $data->news,
                                ]);


                            }

                        ],

//                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
