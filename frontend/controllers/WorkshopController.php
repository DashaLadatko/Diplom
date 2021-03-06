<?php

namespace frontend\controllers;

use Yii;
use common\models\Workshop;
use common\models\search\WorkshopSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Mark;
/**
 * WorkshopController implements the CRUD actions for Workshop model.
 */
class WorkshopController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'restore'],
//                        'roles' => ['*'],
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'restore' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Workshop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkshopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workshop model.
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
     * Creates a new Workshop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Workshop();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Workshop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Workshop model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (in_array(Yii::$app->user->identity->role, array([User::ROLE_ADMIN, User::ROLE_STAFF]))) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionRestore($id)
    {

        if (Yii::$app->user->identity->role !== User::$roles[0]) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->findModel($id)->restore();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Workshop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workshop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionAddmarks()
    {
        if (Yii::$app->request->post()) {
            $model = Mark::findOne([
                'user_id' => Yii::$app->request->post('user_id'),
                'workshop_id' => Yii::$app->request->post('workshop_id'),
            ]);

            if ($model) {
                $model->evaluation = Yii::$app->request->post('evaluation');
            } else {
                $model = new Mark();
                $model->user_id = Yii::$app->request->post('user_id');
                $model->workshop_id = Yii::$app->request->post('workshop_id');
                $model->evaluation = Yii::$app->request->post('evaluation');
            }

            if ($model->save()) {
                return true;
            }
        }
        return false;
    }

    protected function findModel($id)
    {
        if (($model = Workshop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
