<?php

use common\components\filters\SelfHealingUrlFilter;
use notamedia\sentry\SentryTarget;
use yii\i18n\I18N;
use yii\i18n\PhpMessageSource;
use yii\symfonymailer\Mailer;

$params = array_merge(
    require __DIR__ . '/params.php',
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
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => sprintf(
                'mysql:host=%s;dbname=%s',
                env('MYSQL_HOST', 'localhost'),
                env('MYSQL_DATABASE', 'yii2advanced')
            ),
            'username' => env('MYSQL_USER'),
            'password' => env('MYSQL_PASSWORD'),
            'charset' => env('MYSQL_CHARSET', 'utf8'),
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => env('SMTP_CLASS', 'Swift_SmtpTransport'),
                'scheme' => env('SMTP_SCHEME', 'smtp'),
                'host' => env('SMTP_HOST'),
                'username' => env('SMTP_USERNAME'),
                'password' => env('SMTP_PASSWORD'),
                'port' => env('SMTP_PORT', '2525'),
                'encryption' => env('SMTP_ENCRYPTION', 'tls'),
            ],
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
