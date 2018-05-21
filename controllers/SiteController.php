<?php

namespace app\controllers;

use app\models\Markets;
use app\models\News;
use app\models\Stock;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $disabledMarkets = Markets::find()->where(['active' => false])->all();

        $disabledMarketsIds = "";

        $glue = "";
        foreach ($disabledMarkets as $market){
            $disabledMarketsIds .= $glue.$market->id;
            $glue = ",";
        }

        if (!empty($disabledMarketsIds)) {
            $stockDataProvider = new ActiveDataProvider([
                'query' => Stock::find()->where('fk_market NOT IN(' . $disabledMarketsIds . ')'),
                'sort' => [
                    'defaultOrder' => ['capitalization' => SORT_DESC],
                ],
            ]);
        }else {

            $stockDataProvider = new ActiveDataProvider([
                'query' => Stock::find(),
                'sort' => [
                    'defaultOrder' => ['capitalization' => SORT_DESC],
                ],
            ]);
        }

        $newsDataProvider = new ActiveDataProvider([
           'query' =>  News::find()
        ]);

        return $this->render('index', [
            'stockDataProvider' => $stockDataProvider,
            'newsDataProvider' => $newsDataProvider
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionCurrency(){
        return $this->render('currency.php');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
