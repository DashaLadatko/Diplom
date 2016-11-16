<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'd-M-Y',
            'defaultTimeZone' => 'Europe/Kiev', // time zone
        ],

        //  For Languages

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    //'sourceLanguage' => 'en-US',
                    //'fileMap' => [
                    //    'general' => 'general.php',
                    //],
                ],

            ],
        ],
    ]
];
