<?php

namespace app\controllers;

use app\models\Markets;
use app\models\News;
use app\models\Stock;
use Yii;
use app\models\MetaNews;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetaNewsController implements the CRUD actions for MetaNews model.
 */
class MetaNewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MetaNews models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MetaNews::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MetaNews model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MetaNews model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MetaNews();

        if ($model->load(Yii::$app->request->post())) {


            $postData = Yii::$app->request->post();
            if($postData['MetaNews']['dataNews']){
                $model->dataNews = $postData['MetaNews']['dataNews'];


            }
            else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            if($postData['MetaNews']['startTick']){
                $model->startTick = intval($postData['MetaNews']['startTick']);
            }



            if($postData['MetaNews']['dataSectors']){
                $model->dataSectors = $postData['MetaNews']['dataSectors'];


            }
            else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            $arNews = json_decode($model->dataNews,true);

            if($arNews)
            {
                $newsIds = [];
                $sectorIds = [];
                foreach ($model->dataSectors as $sector)
                {
                    $sectorIds[] = $sector;

                    foreach ($arNews as $data)
                    {
                        $news = new News();

                        $news->fk_market = $data['market'];
                        $news->priority = $data['priority'];
                        $news->type = $data['type'];
                        $news->tick = $model->startTick;
                        $news->ttl = $data['ttl'];
                        $news->title = $model->titl;
                        $news->text = "Created by MetaNews: ". $model->titl;

                        $news->sector = $sector;
                        $news->save();

                        $newsIds[] = $news->id;
                    }
                }
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }


            $model->setNews($newsIds);
            $model->setSectors($sectorIds);

            if ($model->save()){
                return $this->redirect(['meta-news/index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MetaNews model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MetaNews model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MetaNews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MetaNews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MetaNews::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
