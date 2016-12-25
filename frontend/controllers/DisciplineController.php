<?php
namespace frontend\controllers;
use Yii;
use common\models\Discipline;
use common\models\search\DisciplineSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Course;
/**
 * DisciplineController implements the CRUD actions for Discipline model.
 */
class DisciplineController extends Controller
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
     * Lists all Discipline models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisciplineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $evaluation = array();

        $components = Yii::$app->db->createCommand( 'SELECT course_id FROM `course_user` WHERE user_id = '.Yii::$app->user->identity->getId() )->queryAll();

        foreach ($components as $row){
            $model = Yii::$app->db->createCommand( 'SELECT AVG( mark.evaluation) as eval '
                .' FROM workshop, user, topic, mark, topic_course '
                .'WHERE workshop.topic_id = topic_course.topic_id AND mark.user_id = user.id AND mark.workshop_id=workshop.id '
                .' AND topic.id=topic_course.topic_id AND topic_course.course_id ='.$row['course_id'] )->queryAll();

            $cour = Course::findOne($row['course_id']);
            $evaluation[] = array('name' => $cour->name, 'data'=>[(int)$model[0]['eval'],]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'evaluation' => $evaluation,
        ]);
    }
    /**
     * Displays a single Discipline model.
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
     * Creates a new Discipline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Discipline();
        if ($model->load(Yii::$app->request->post())  && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Discipline model.
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
     * Deletes an existing Discipline model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMIN) {
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
        if (Yii::$app->user->identity->role !== User::ROLE_ADMIN) {
            throw new ForbiddenHttpException('Access denied');
        }
        $this->findModel($id)->restore();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Discipline model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discipline the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discipline::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}