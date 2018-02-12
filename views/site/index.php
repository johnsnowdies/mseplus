<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Валюты</h2>

                <p>Государственные валюты</p>

                <p><a class="btn btn-default" href="/currencies/">Управление</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Биржи</h2>

                <p>Торговые системы</p>

                <p><a class="btn btn-default" href="/markets/">Управление</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Компании</h2>

                <p>Компании разместившие акции на биржах</p>

                <p><a class="btn btn-default" href="/stock/">Управление</a></p>
            </div>
        </div>

    </div>
</div>
