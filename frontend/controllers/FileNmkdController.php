<?php

namespace frontend\controllers;


use Yii;
use yii\helpers\ArrayHelper;
use common\models\Filenmkd;
use common\models\search\FilenmkdSearch;
use common\models\Uploadfile;
use common\models\User;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * FilenmkdController implements the CRUD actions for Filenmkd model.
 */
class FilenmkdController extends Controller
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
     * Lists all Filenmkd models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        $searchModel = new FilenmkdSearch();
        if( Yii::$app->user->identity->role === User::ROLE_STAFF) {
            $dataProvider = $searchModel->search(ArrayHelper::merge( Yii::$app->request->queryParams, [$searchModel->formName() => ['user_id' => Yii::$app->user->identity->getId()]]) );

        }else{
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams//ArrayHelper::merge( Yii::$app->request->queryParams], [$searchModel->formName() => ['user_id' => 3])
            );
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Filenmkd model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Filenmkd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($action = 0)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        $disciplines = Yii::$app->db->createCommand(
            'select discipline.id, discipline.name from user, discipline, discipline_user
            WHERE discipline_user.discipline_id = discipline.id and discipline_user.user_id = user.id AND user.id = '.Yii::$app->user->identity->getId())//
        ->queryAll();
        if ($action === 0 || $action === '') {
            $components = array();

        }else{
            $components = Yii::$app->db->createCommand(
                'select id, component_nmkd.name from component_nmkd where id NOT IN (select component_nmkd_id from file_nmkd
            WHERE discipline_id = ' . $action . ' AND user_id = '.Yii::$app->user->identity->getId().')')
                ->queryAll();

        }


        if (Yii::$app->request->post()) {
            if(!empty(Yii::$app->request->post('component'))) {
                foreach(Yii::$app->request->post('component') as $check) {
                    $model = new Filenmkd();
                    $model->component_nmkd_id = $check;
                    $model->user_id = Yii::$app->user->identity->getId();
                    $model->discipline_id = Yii::$app->request->post('list');
                    $model->signature = 'не завантажено';
                    $model->protocol_chair =0;
                    $model->protocol_fuculty =0;
                    $model->protocol_university =0;
                    $model->total =0;
                    //$model->created_at = time();
                    $model->created_by = Yii::$app->user->identity->getId();//user_id
                    // $model->updated_at = time();
                    $model->updated_by=Yii::$app->user->identity->getId();//user_id
                    $model->comment = '';

                    $model->save();
                }
            }

            return $this->redirect(['index',]);
        } else {
            return $this->render('create', ['components' =>$components,'disciplines' => $disciplines,]);
        }

        /*
       if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model, 'components' =>$components,
            ]);
        }*/
    }



    /**
     * Updates an existing Filenmkd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = $this->findModel($id);




        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            //$model->updated_at = time();
            if($model->name === ''){
                $model->signature = 'не завантажено';
                $model->total = 0;
                $model->protocol_fuculty = 0;
                $model->protocol_chair =0;
                $model->protocol_university = 0;
            } else {
                if($model->total === 0){
                    $model->signature = 'на розгляді';
                } else {
                    $model->signature = 'затверджено';
                    $model->protocol_fuculty = 1;
                    $model->protocol_chair = 1;
                    $model->protocol_university = 1;
                }
            }
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id, 'tot' => $model->total]);
        } else {
            return $this->render('update', [
                'model' => $model,// 'file' =>$file,
            ]);
        }
    }

    /**
     * Deletes an existing Filenmkd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionFile($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        $up_file = new Uploadfile();


        if (Yii::$app->request->isPost) {
            $up_file->imageFile = UploadedFile::getInstance($up_file, 'imageFile');
            $model = $this->findModel($id);
            if ($up_file->upload($model->user_id)) {

                $model->name =   $up_file->imageFile->name;
                $model->signature = 'на розгляді';
                $model->save( false);
                return $this->redirect(['view', 'id' => $model->id, ]);

            }
        }

        return $this->render('file', ['up_file' => $up_file]);
    }
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletefile($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        $model =  $this->findModel($id);
        $model ->name = '';
        $model->signature ='не завантажено';
        $model->save(false);
        //удалить файл из папки

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDownload($id)
    {
        if (Yii::$app->user->identity->role !== User::ROLE_ADMINNMKD
            && Yii::$app->user->identity->role !== User::ROLE_CHIEF
            && Yii::$app->user->identity->role !== User::ROLE_STAFF) {
            throw new ForbiddenHttpException('Access denied');
        }
        $model = $this->findModel($id);
        $file = Yii::getAlias('@frontend/web/uploads/'.$model->user_id.'/'.$model->name);

        return Yii::$app->response->sendFile($file);
    }

    /**
     * Finds the Filenmkd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Filenmkd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Filenmkd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
