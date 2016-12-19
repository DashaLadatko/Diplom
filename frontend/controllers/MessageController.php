<?php

namespace frontend\controllers;

use Yii;
use common\models\Message;
use common\models\search\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Group;
use common\models\search\GroupSearch;
use common\models\User;
use common\models\search\UserSearch;
/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
//        return [
////            'access' => [
////                'class' => AccessControl::className(),
////                'rules' => [
////                    [
////                        'allow' => true,
////                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'restore'],
////                        'roles' => ['*'],
////                    ],
////                ],
////            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                    'restore' => ['POST'],
//                ],
//            ],
//        ];
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view', 'message'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'create' => ['POST'],
                    'update' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $searchModel = new MessageSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        if(Yii::$app->user->identity->role == 1){
            $searchModel = new GroupSearch();
            $dataProvider = $searchModel->searchGroupForMessage(Yii::$app->request->queryParams);
            return $this->render('index_teacher', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->searchTeacherForMessage(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $userSearch = new UserSearch();
        $userSearch->group_id = $id;
        $dataProvider = $userSearch->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $userSearch,
            'dataProvider' => $dataProvider,
        ]);
//        {
//            $user = User::findOne($id);
//            $group = Group::findOne($user->group_id);
//            $model = new Message();
//            $modelMessage = $user->senderMessage;
////            Messages::dialogButton($user);
//            if ($model->load(Yii::$app->request->post())) {
//                $model->id_from = Yii::$app->user->id;
//                $model->id_to = $id;
//                $model->date = time();
//                $model->read_or_not = 1;
//                if ($model->save()) {
//                    Yii::$app->getSession()->setFlash('success', "Повідомлення надіслано :)");
//                    $model->message = "";
//                    return $this->render('message',
//                        ['user' => $user,
//                            'group' => $group,
//                            'model' => $model]);
//                }else{
//                    Yii::$app->getSession()->setFlash('error', "Щось зламалось. Повідомлення не надіслано :(");
//                }
//            }
//            return $this->render('message',
//                [
//                    'user' => $user,
//                    'modelMessage' => $modelMessage,
//                    'group' => $group,
//                    'model' => $model]);
//        }
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();
        $model->load(Yii::$app->request->post());
        $model->save();
        return $this->redirect(['message', 'id' => $model->id]);
    }

    /**
     * Updates an existing Message model.
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
     * Deletes an existing Message model.
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
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMessage($id)
    {
        $user = User::findOne($id);
        $group = Group::findOne($user->group_id);

        $model = new Message();
        $modelMessage = $model->MessageForChat($id);
        Message::dialogButton($user);
        if ($model->load(Yii::$app->request->post())) {
            $model->from_user_id = Yii::$app->user->id;
            $model->to_user_id = $id;
            $model->created_at = time();
            $model->read_or_not = 1;
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', "Повідомлення надіслано");
                $model->text = "";
                return $this->render('message',
                    [
                        'user' => $user,
                        'group' => $group,
                        'modelMessage' => $modelMessage,
                        'model' => $model
                    ]);
            }else{
                Yii::$app->getSession()->setFlash('error', "Щось зламалось. Повідомлення не надіслано");
            }
        }
        return $this->render('message',
            [
                'user' => $user,
                'group' => $group,
                'modelMessage' => $modelMessage,
                'model' => $model]);
    }
}
