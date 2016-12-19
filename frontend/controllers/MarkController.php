<?php

namespace frontend\controllers;

use Yii;
use common\models\Mark;
use common\models\Course;
use common\models\search\MarkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarkController implements the CRUD actions for Mark model.
 */
class MarkController extends Controller
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
     * Lists all Mark models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mark model.
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
     * Creates a new Mark model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mark();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mark model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mark model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->role !== User::$roles[0]) {
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
     * Finds the Mark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mark::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGraph()
    {
        $evaluation = array();

        $components = Yii::$app->db->createCommand( 'SELECT DISTINCT (topic_course.course_id) as course1 FROM workshop, user, topic, mark, topic_course'
            .' WHERE workshop.topic_id = topic_course.topic_id AND mark.user_id = user.id AND mark.workshop_id=workshop.id'
            .' AND topic.id=topic_course.topic_id AND user.id = '.Yii::$app->user->identity->getId() )->queryAll();

        foreach ($components as $row){
            $model = Yii::$app->db->createCommand( 'SELECT mark.id, topic.name, mark.evaluation as eval, topic_course.course_id FROM workshop, user, topic, mark, topic_course'
                .' WHERE workshop.topic_id = topic_course.topic_id AND mark.user_id = user.id AND mark.workshop_id=workshop.id'
                .' AND topic.id=topic_course.topic_id AND user.id = '.Yii::$app->user->identity->getId().
                ' AND topic_course.course_id='.$row['course1'] )->queryAll();

            $mod1 = array();
            foreach ($model as $mod){

                $mod1[] =$mod['eval'];
            }
            $cour = Course::findOne($row['course1']);
            $evaluation[] = array('name' => $cour->name, 'data'=>array_map('intVal', $mod1));
        }
        return $this->render('graph', [
            'evaluation' => $evaluation,
        ]);
    }
}
