<?php

return [
    'components' => [

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=start',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'name@gmail.com',
                'password' => 'pass',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
            ],
        ],

        'uploader' => [
            'class' => '\common\components\upload\uploader',

            'folder' => '', // backend
            'module' => 'static',
            'default_name_length' => 10,

            // default image for Object
            'default_image' => [
                'Object' => 'pathToDefaultImage', //   'event' => 'default/event/logo.png',

                'ElseObject' => [ // if you want to add a thumbnail for each type
                    \common\components\upload\uploader::TYPE_DOCUMENT => 'default/attachment/document-icon.png',
                    \common\components\upload\uploader::TYPE_VIDEO => 'default/attachment/video-icon.jpeg',
                    \common\components\upload\uploader::TYPE_IMAGE => 'default/attachment/image-icon.jpeg',
                    \common\components\upload\uploader::TYPE_AUDIO => 'default/attachment/audio-icon.png',
                    \common\components\upload\uploader::TYPE_ARCHIVE => 'default/attachment/archive-icon.png',
                ],
            ]
        ],

        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => array_values(\common\models\User::$roles),
            'itemFile' => '@common/components/rbac/config/items.php',
            'assignmentFile' => '@common/components/rbac/config/assignments.php',
            'ruleFile' => '@common/components/rbac/config/rules.php'
        ]
    ],
];