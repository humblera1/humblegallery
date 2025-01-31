<?php

use common\components\filters\SelfHealingUrlFilter;
use notamedia\sentry\SentryTarget;
use yii\i18n\I18N;
use yii\i18n\PhpMessageSource;

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'name' => 'HG',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'container' => [
        'definitions' => [
            SelfHealingUrlFilter::class => [
                'urlParamName' => 'slugHash',
            ],
        ],
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => SentryTarget::class,
                    'dsn' => $params['sentry.dsn'],
                    'levels' => ['error', 'warning'],
                    'context' => true,
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
            ]
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'class' => I18N::class,
            'translations' => [
                'app' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
];
