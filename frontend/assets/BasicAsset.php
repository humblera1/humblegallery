<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Main frontend application asset bundle.
 */
class BasicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap/bootstrap.css',
        'css/site.css',
        'css/frontend.css',
    ];

    public $js = [
        'js/main/index.js',
    ];

    public $depends = [
        YiiAsset::class,
        FontAwesomeAsset::class
    ];
}
