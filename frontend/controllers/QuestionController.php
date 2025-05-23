<?php

namespace frontend\controllers;

use common\models\Question;
use common\models\search\QuestionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Question models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new Question();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if($model->img_path){
                    unlink($model->img_path);
                    $model->img_path = '';
                    $model->save(false);
                }

                $model->file  = UploadedFile::getInstance($model, 'file');

                if ($model->file) {
                    $filePath = 'uploads/'
                        . Yii::$app->security->generateRandomString(8)
                        . '.' . $model->file->extension;
                    $model->file->saveAs($filePath);
                    $model->img_path = $filePath;
                }
                $model->test_id = $id;
                $model->save(false);

                return $this->redirect(['test/view', 'id' => $model->test_id, 'mode' => 'test']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            if($model->img_path){
                unlink($model->img_path);
                $model->img_path = '';
                $model->save(false);
            }

            $model->file  = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $filePath = 'uploads/'
                    . Yii::$app->security->generateRandomString(8)
                    . '.' . $model->file->extension;
                $model->file->saveAs($filePath);
                $model->img_path = $filePath;
            }
            $model->save(false);

            return $this->redirect(['test/view', 'id' => $model->test_id, 'mode' => 'test']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $test_id = $model->test_id;
        if($model->img_path){
            unlink($model->img_path);
        }
        $model->delete();

        return $this->redirect(['test/view', 'id' => $test_id, 'mode' => 'test']);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
