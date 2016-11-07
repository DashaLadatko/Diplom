<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Class PasswordResetRequestForm
 * @package frontend\models
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],

            ['email', 'email'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'exist', 'targetClass' => '\common\models\User', 'filter' => ['status' => User::STATUS_ACTIVE], 'message' => 'There is no user with such email.'],
        ];
    }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }

        if (!$user->save()) {
            return false;
        }

        return Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
