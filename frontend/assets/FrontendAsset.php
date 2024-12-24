<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot/js/dist';
    public $baseUrl = '@web/js/dist';

//    public $css = [
//        'css/bootstrap/bootstrap.css',
//        'css/site.css',
//        'css/frontend.css',
//    ];

    public $js = [
        'bundle.js',
    ];

    public $depends = [
        YiiAsset::class,
    ];
}