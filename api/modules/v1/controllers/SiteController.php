<?php
namespace api\modules\v1\controllers;

use common\models\LoginForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use common\models\User;

use Yii;
use yii\base\InvalidParamException;
use yii\behaviors;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\filters\auth\QueryParamAuth;

/**
 * Class SiteController
 * @package api\modules\v1\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'only' => [
                'auth'
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [
                'auth',
            ],
            'rules' => [
                [
                    'actions' => [
                        'auth'
                    ],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ]
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'login' => ['POST'],
                'auth' => ['GET'],
                'request-password-reset' => ['POST'],
                'reset-password' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return User::auth(Yii::$app->user->identity);
        }
        return ['error' => Yii::t('app', $model->getErrors())];
    }

    public function actionAuth()
    {
        return User::auth(Yii::$app->user->identity);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->sendEmail()) {
            return Yii::t('app', 'Check your email for further instructions.');
        }
        return ['error' => Yii::t('app', 'Sorry, we are unable to reset password for email provided.')];
    }

    public function actionResetPassword()
    {
        try {
            $model = new ResetPasswordForm(Yii::$app->request->post('token'));
        } catch (InvalidParamException $e) {
            return ['error' => Yii::t('app', $e->getMessage())];
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            return Yii::t('app', 'New password was saved.');
        }
        return ['error' => $model->getErrors()];
    }
}
