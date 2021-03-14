<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@frontendUrl' => 'http://yii2-ecommerce.localhost'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => common\components\Formatter::class,
            'datetimeFormat' => 'php:d/m/Y H:i'
        ]
    ],
];
