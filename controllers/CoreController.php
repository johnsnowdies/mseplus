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

    public function actionSidebar(){
        $session = Yii::$app->session;

        $currentState = $session->get('sidebar');

        if(!$currentState)
            $session->set('sidebar', true);
        else
            $session->set('sidebar', false);

        return $session->get('sidebar');
    }

}
