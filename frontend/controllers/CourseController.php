<?php
namespace frontend\controllers;
use Yii;
use common\models\Course;
use common\models\search\CourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\CourseGroupUser;
/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'evaluation' => $evaluation,
        ]);
    }
    /**
     * Displays a single Course model.
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
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Course model.
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
     * Deletes an existing Course model.
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
    public function actionRestore($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMIN) {
            throw new ForbiddenHttpException('Access denied');
        }
        $this->findModel($id)->restore();
        return $this->redirect(['index']);
    }
    public function actionAddgroupbycourse($id)
    {
        $model = new CourseGroupUser();
        $request = Yii::$app->request->post();
//        if ($request['_pjax']) {
        if (!CourseGroupUser::find()->where(['group_id' => $id, 'course_id' => $request['course_id']])->one()) {
            if ($id) {
                $model->course_id = $request['course_id'];
                $model->group_id = $id;
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', "Групу додано");
                    return true;
                } else {
                    Yii::$app->getSession()->setFlash('error', "Щось зламалось. Групу не додано");
                }
            }
        }
        Yii::$app->getSession()->setFlash('error', "Дана група вже додана до цього курсу");
//        }
        return false;
    }
    public function actionViewgroup($id)
    {
        $request = Yii::$app->request->get();
//        if (!$request['_pjax']) {
        $group = Group::findOne($id);
        $course = Course::findOne($request['course']);
        $userSearch = new UserSearch();
        return $this->render('group_view', [
            'course' => $course,
            'group' => $group,
            'userSearch' => $userSearch,
        ]);
//        }
    }
    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}