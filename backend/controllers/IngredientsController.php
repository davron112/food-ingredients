<?php

namespace backend\controllers;

use Yii;
use common\models\Ingredients;
use common\models\IngredientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\web\UploadedFile;


Yii::setAlias('imageFolder', dirname(dirname(__DIR__)) . '/frontend/web/images/');

/**
 * IngredientsController implements the CRUD actions for Ingredients model.
 */
class IngredientsController extends Controller
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
     * Lists all Ingredients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IngredientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ingredients model.
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
     * Creates a new Ingredients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ingredients();
        if ($model->load(Yii::$app->request->post())) {
            $filename = rand(10000, 9999999);
            $model->img = UploadedFile::getInstance($model,'img');
            if (!empty($model->img)){
                $model->img->saveAs( Yii::getAlias('@imageFolder/original/').$filename.'.'.$model->img->extension );
                $model->img =  $filename.'.'.$model->img->extension;
                $imagine = Image::getImagine();
                $image = $imagine->open(Yii::getAlias('@imageFolder/original/'.$model->img));
                $image->resize(new Box(150, 150))->save(Yii::getAlias('@imageFolder/'.$model->img, ['quality' => 100]));
            }
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                Yii::$app->session->setFlash('error', 'Saqlanmadi');
                return $this->render('create', [
                    'model' => $model
                ]);}
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }


    /**
     * Updates an existing Ingredients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
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
                    $image->resize(new Box(150, 150))->save(Yii::getAlias('@imageFolder/'.$model->img, ['quality' => 100]));
                }
            }else{
                $model->img = $this->findModel($id)->img;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);}
        }else {
            return $this->render('update', [
                'model' => $model,
            ]);}
    }

    /**
     * Deletes an existing Ingredients model.
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
     * Finds the Ingredients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ingredients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ingredients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
