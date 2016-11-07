<?php
namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use common\components\rbac\RoleRules;
use yii\helpers\Console;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        $RoleRules = new RoleRules();
        $rbacRoles = [];

//      $admin = $authManager->createRole('ADMIN');

        foreach (User::$roles as $role) {
            $rbacRoles[] = $authManager->createRole($role);
        }

        $login = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $error = $authManager->createPermission('error');
        $signUp = $authManager->createPermission('sign-up');
        $index = $authManager->createPermission('index');
        $view = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);

        $authManager->add($RoleRules);

//        $admin->ruleName = $RoleRules->name;
//        $authManager->add($admin);

        foreach ($rbacRoles as $rbacRole) {
            $rbacRole->ruleName = $RoleRules->name;
            $authManager->add($rbacRole);
        }

        $authManager->addChild($rbacRoles[0], $login);
        $authManager->addChild($rbacRoles[0], $logout);
        $authManager->addChild($rbacRoles[0], $error);
        $authManager->addChild($rbacRoles[0], $signUp);
        $authManager->addChild($rbacRoles[0], $index);
        $authManager->addChild($rbacRoles[0], $view);


        // TODO: Write Role to all role
//        $authManager->addChild($admin, $elseRole);

        $this->stdout($this->ansiFormat("\n Role up successfully.\n", Console::FG_GREY), Console::BOLD);
    }
}