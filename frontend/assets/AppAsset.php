<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap/bootstrap.css',
        'css/site.css',
        'css/frontend.css',
    ];
    public $js = [
        'https://kit.fontawesome.com/59b8304312.js',
        'js/main/main.js',
    ];
    public $depends = [
        YiiAsset::class,
        FontAwesomeAsset::class
    ];
}
