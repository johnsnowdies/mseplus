<?php
/* @var $this \yii\web\View */

/* @var $content string */

use jcabanillas\inspinia\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;
use app\assets\AppAsset as MyAsset;

MyAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/jcabanillas/yii2-inspinia/assets');
AppAsset::register($this);
$session = Yii::$app->session;
$currentSidebarState = $session->get('sidebar');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        button a i{
            color: #000000!important;
        }
        .minimalize-styl-2{
            margin: 18px 5px 5px 0px!important;
        }

        .up { bottom:100% !important; top:auto !important; }

        tr.filters{
            display:none;

        }
    </style>
</head>

<body <?= ($currentSidebarState)? 'class="mini-navbar"':''?> ></body><?php $this->beginBody() ?>

<div id="wrapper" class="">

    <?= $this->render('sidebar', ['directoryAsset' => $directoryAsset]) ?>

    <div id="page-wrapper" class="gray-bg">


        <div class="row wrapper border-bottom white-bg page-heading">
            <?php if (isset($this->blocks['content-header'])) { ?>
                <?= $this->blocks['content-header'] ?>
            <?php } else { ?>
                <div class="col-sm-<?= isset($this->blocks['content-header-actions']) ? 6 : 10 ?>">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <h2><?= $this->title ?></h2>


                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n"
                    ])
                    ?>
                </div>
                <div class="col-sm-2">
                    <h2>Биржа <div class="switch pull-right">
                            <div class="onoffswitch" style="margin-top: 5px;">
                                <input type="checkbox" checked="" class="onoffswitch-checkbox" id="example1">
                                <label class="onoffswitch-label" for="example1">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div></h2>


                </div>
                <?php if (isset($this->blocks['content-header-actions'])): ?>
                    <div class="col-sm-6">

                        <div class="title-action">
                            <?= $this->blocks['content-header-actions'] ?>
                        </div>
                    </div>
                <?php endif ?>
            <?php } ?>

        </div>

        <div class="wrapper wrapper-content">


            <div class="row">
                <div class="col-lg-12">
                    <?= $content ?>
                </div>
            </div>
        </div>
        <?= $this->render('footer', ['directoryAsset' => $directoryAsset]) ?>


    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
