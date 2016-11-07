<?php

namespace common\components\extended;

use Yii;
use common\models\User;
use yii\web\IdentityInterface;
use common\components\traits\identity;

/**
 * Class extUser
 * @package common\components\extended
 */
class extUser extends extActiveRecord implements IdentityInterface
{
    use identity;

    /**
     * @param int $role
     * @param int $status
     * @return bool
     *
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function initUser($role, $status = self::STATUS_ACTIVE)
    {
        /** @var $this User */

        if (isset($status, $role, $this->password)) {

            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $this->status = $status;
            $this->role = $role;

            $this->generatePasswordResetToken();
            $this->generateAuthKey();

            return true;
        }
        return false;
    }
}