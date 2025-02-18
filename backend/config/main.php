<?php

use backend\components\widgets\HumbleActiveField;
use common\modules\admin\AdminModule;
use common\modules\artist\ArtistModule;
use common\modules\collection\CollectionModule;
use common\modules\movement\MovementModule;
use common\modules\painting\PaintingModule;
use common\modules\subject\SubjectModule;
use common\modules\technique\TechniqueModule;
use common\modules\user\UserModule;
use kartik\date\DatePicker;
use yii\i18n\Formatter;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
);

return [
    'id' => 'humblegallery',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'container' => [
        'definitions' => [
            ActiveForm::class => [
                'fieldClass' => HumbleActiveField::class
            ],
            DatePicker::class => [
                'options' => [
                    'class' => ['form-group'],
                ],
            ],
            DetailView::class => [
                'formatter' => [
                    'class' => Formatter::class,
                    'dateFormat' => 'php:d.m.Y',
                ],
            ],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => AdminModule::class,
            'controllerNamespace' => 'common\modules\admin\controllers',
            'viewPath' => '@common/modules/admin/views',
        ],
        'user' => [
            'class' => UserModule::class,
            'controllerNamespace' => 'common\modules\user\controllers\admin',
            'viewPath' => '@common/modules/user/views/admin',
        ],
        'painting' => [
            'class' => PaintingModule::class,
            'controllerNamespace' => 'common\modules\painting\controllers\admin',
            'viewPath' => '@common/modules/painting/views/admin',
        ],
        'artist' => [
            'class' => ArtistModule::class,
            'controllerNamespace' => 'common\modules\artist\controllers\admin',
            'viewPath' => '@common/modules/artist/views/admin',
        ],
        'movement' => [
            'class' => MovementModule::class,
            'controllerNamespace' => 'common\modules\movement\controllers\admin',
            'viewPath' => '@common/modules/movement/views/admin',
        ],
        'technique' => [
            'class' => TechniqueModule::class,
            'controllerNamespace' => 'common\modules\technique\controllers\admin',
            'viewPath' => '@common/modules/technique/views/admin',
        ],
        'subject' => [
            'class' => SubjectModule::class,
            'controllerNamespace' => 'common\modules\subject\controllers\admin',
            'viewPath' => '@common/modules/subject/views/admin',
        ],
        'collection' => [
            'class' => CollectionModule::class,
            'controllerNamespace' => 'common\modules\collection\controllers\admin',
            'viewPath' => '@common/modules/collection/views/admin',
        ],
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
        ],
        'request' => [
            'csrfParam' => env('BACKEND_CSRF_PARAM'),
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
