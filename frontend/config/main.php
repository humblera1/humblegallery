<?php

use common\components\widgets\LinkPager;
use common\modules\artist\ArtistModule;
use common\modules\collection\CollectionModule;
use common\modules\painting\PaintingModule;
use common\modules\user\models\data\User;
use common\modules\user\UserModule;
use yii\bootstrap5\ActiveField;
use yii\caching\FileCache;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
);

$rules = require __DIR__ . '/rules.php';

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'container' => [
        'definitions' => [
            ActiveField::class => [
                'template' => "<div class='form-group__content'>{label}\n{input}</div>\n{error}",
                'options' => [
                    'class' => 'form-group form-group_horizontal',
                ],
            ],
            LinkPager::class => [
                'options' => [
                    'class' => 'pagination'
                ],
                'linkContainerOptions' => [
                    'class' => 'pagination__item',
                ],
                'linkOptions' => [
                    'class' => 'pagination__link',
                ],
                'pageCssClass' => 'pagination__page',
                'activePageCssClass' => 'pagination__page_active',
                'separatorContainerClass' => 'pagination__container',
                'separatorContentClass' => 'pagination__separator',
                'registerLinkTags' => true,
            ],
        ],
    ],
    'modules' => [
        'painting' => [
            'class' => PaintingModule::class,
            'controllerNamespace' => 'common\modules\painting\controllers\frontend',
            'viewPath' => '@common/modules/painting/views/frontend',
        ],
        'artist' => [
            'class' => ArtistModule::class,
            'controllerNamespace' => 'common\modules\artist\controllers\frontend',
            'viewPath' => '@common/modules/artist/views/frontend',
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
            'csrfParam' => env('FRONTEND_CSRF_PARAM'),
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
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
            'rules' => $rules,
        ],
    ],
    'params' => $params,
];
