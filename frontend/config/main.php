<?php

use backend\components\widgets\HumbleActiveField;
use common\modules\collection\CollectionModule;
use common\modules\painting\PaintingModule;
use common\modules\user\models\data\User;
use common\modules\user\UserModule;
use yii\caching\FileCache;
use yii\widgets\ActiveForm;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'container' => [
        'definitions' => [
            ActiveForm::class => [
                'fieldClass' => HumbleActiveField::class
            ],
        ],
    ],
    'modules' => [
        'painting' => [
            'class' => PaintingModule::class,
            'controllerNamespace' => 'common\modules\painting\controllers\frontend',
            'viewPath' => '@common/modules/painting/views/frontend',
        ],
        'user' => [
            'class' => UserModule::class,
            'controllerNamespace' => 'common\modules\user\controllers\frontend',
            'viewPath' => '@common/modules/user/views/frontend',
        ],
        'collection' => [
            'class' => CollectionModule::class,
            'controllerNamespace' => 'common\modules\collection\controllers\frontend',
            'viewPath' => '@common/modules/collection/views/frontend',
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'paintings' => 'painting/default/index',
                'paintings/<action>' => 'painting/default/<action>',
                'collection/<action>' => 'collection/default/<action>',

                '' => 'site/index', //TODO:поправить маршрут

                'user/<action>' => 'user/default/<action>',
//                'profile/<section>' => 'user/default/<section>',
                [
                    'pattern' => 'profile/<section:\w+>',
                    'route' => 'user/default/profile',
                    'defaults' => [
                        'section' => 'info',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
