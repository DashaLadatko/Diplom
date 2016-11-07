<?php

namespace common\components\rbac;

use Yii;
use yii\rbac\Rule;
use common\models\User;

/**
 * Class RoleRules
 * @package common\components\rbac
 */
class RoleRules extends Rule
{
    /**
     * @param int|string $user
     * @param \yii\rbac\Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {

            $name = User::FIELD_ROLE;
            foreach (User::$roles as $key => $role) {
                if($item->name === $role){
                    return Yii::$app->user->identity->$name === $role;
                }
            }
        }
        return false;
    }
}