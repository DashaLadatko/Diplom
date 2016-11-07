<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];


if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
    ];

    $config['bootstrap'][] = 'gii';

    if (YII_ENV_DEV) {
        $config['modules']['gii'] = [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],
            'generators' => [
                'controller' => [
                    'class' => 'yii\gii\generators\controller\Generator',
                    'templates' => [
                        'Restful Api Active Controller' => '@common/components/gii/controller/ActiveController/default',
                        'Restful Api Rest Controller' => '@common/components/gii/controller/RestController/default',
                    ]
                ],
                'model' => [
                    'class' => 'yii\gii\generators\model\Generator',
                    'templates' => [
                        'Restful Api Model' => '@common/components/gii/model/default',
                    ]
                ]
            ]
        ];
    }
}

return $config;
