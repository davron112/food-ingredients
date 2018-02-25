<?php

namespace backend\controllers;

use common\models\Ingredients;
use Yii;
use common\models\Foods;
use common\models\FoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\web\UploadedFile;



Yii::setAlias('imageFolder', dirname(dirname(__DIR__)) . '/frontend/web/images/');

/**
 * FoodsController implements the CRUD actions for Foods model.
 */
class FoodsController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Foods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Foods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Foods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Foods();
        $model->loadDefaultValues();
        $data = Ingredients::find()->select(['title', 'id'])->indexBy('id')->active()->column();
        if ($model->load(Yii::$app->request->post())) {
        $filename = rand(10000, 9999999);
        $model->img = UploadedFile::getInstance($model,'img');
        if (!empty($model->img)){
        $model->img->saveAs( Yii::getAlias('@imageFolder/original/').$filename.'.'.$model->img->extension );
        $model->img =  $filename.'.'.$model->img->extension;
        $imagine = Image::getImagine();
        $image = $imagine->open(Yii::getAlias('@imageFolder/original/'.$model->img));
        $image->resize(new Box(280, 220))->save(Yii::getAlias('@imageFolder/'.$model->img, ['quality' => 100]));
        }
        if ($model->save()){
            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            Yii::$app->session->setFlash('error', 'Saqlanmadi');
            return $this->render('create', [
                'model' => $model,
                'data' => $data
            ]);}
        } else {
            return $this->render('create', [
                'model' => $model,
                'data' => $data
            ]);
        }
    }

    /**
     * Updates an existing Foods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Ingredients::find()->select(['title', 'id'])->indexBy('id')->active()->column();
        if ($model->load(Yii::$app->request->post())) {
        $model->img = UploadedFile::getInstance($model, 'img');
        if (!empty($model->img) || isset($model->img)){
        @unlink(Yii::getAlias('@imageFolder/' . $this->findModel($id)->img));
        @unlink(Yii::getAlias('@imageFolder/original/' . $this->findModel($id)->img));

            // get the instance of the uploaded file
        $filename = rand(10000, 9999999);

        if (!empty($model->img)) {
        $model->img->saveAs(Yii::getAlias('@imageFolder/original/') . $filename . '.' . $model->img->extension);
        $model->img = $filename . '.' . $model->img->extension;
        $imagine = Image::getImagine();
        $image = $imagine->open(Yii::getAlias('@imageFolder/original/'.$model->img));
        $image->resize(new Box(280, 220))->save(Yii::getAlias('@imageFolder/'.$model->img, ['quality' => 100]));
        }
        }else{
            $model->img = $this->findModel($id)->img;
        }
        if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'data' => $data
            ]);}
        }else {
            return $this->render('update', [
                'model' => $model,
                'data' => $data
            ]);}
        }

    /**
     * Deletes an existing Foods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        @unlink(Yii::getAlias('@imageFolder/' . $this->findModel($id)->img));
        @unlink(Yii::getAlias('@imageFolder/original/' . $this->findModel($id)->img));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Foods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Foods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Foods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
