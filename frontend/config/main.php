<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'request' => [
            'baseUrl' => '/frontend/web',
//  For Languages
//            'class' => 'common\components\language\LangRequest',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//  For Languages
//            'class' => 'common\components\language\LangUrlManager',
            'rules' => [

//  For Languages
//                '' => 'site/index',
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
//                '<action>' => 'site/<action>',
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],

    ],
    'params' => $params,
];
