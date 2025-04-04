<?php

use yii\console\controllers\FixtureController;
use yii\console\controllers\MigrateController;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'db' => 'db',
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',
                '@common/modules/user/migrations',
                '@common/modules/artist/migrations',
                '@common/modules/painting/migrations',
                '@common/modules/movement/migrations',
                '@common/modules/subject/migrations',
                '@common/modules/technique/migrations',
                '@common/modules/collection/migrations',
            ]
        ],
        'fixture' => [
            'class' => FixtureController::class,
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
