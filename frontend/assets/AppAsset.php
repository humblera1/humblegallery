<?php

namespace frontend\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/frontend.css',
    ];
    public $js = [
        'https://kit.fontawesome.com/59b8304312.js',
        'js/main/bootstrap.bundle.min.js',
        'js/main/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        BootstrapAsset::class,
    ];
}
