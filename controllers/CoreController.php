<?php

namespace app\controllers;

use Yii;

class CoreController extends \yii\web\Controller
{
    public function actionCurrency($name)
    {
        if ($name == 'nodata')
            $name = null;
            
        $session = Yii::$app->session;
        $session->set('currency', $name);        
    }

}
