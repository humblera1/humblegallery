<?php

namespace frontend\assets\painting;

use frontend\assets\BasicAsset;
use frontend\assets\masonry\PaintingMasonryAsset;
use yii\web\AssetBundle;

class PaintingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/painting/index.js',
    ];

    public $depends = [
        BasicAsset::class,
        PaintingMasonryAsset::class,
    ];
}