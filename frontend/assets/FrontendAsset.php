<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot/js/dist';
    public $baseUrl = '@web/js/dist';

    public $js = [
        'main.js',
    ];

    public $depends = [
        YiiAsset::class,
    ];
}