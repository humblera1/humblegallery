<?php

namespace frontend\assets\profile;

use frontend\assets\BasicAsset;
use frontend\assets\masonry\PaintingMasonryAsset;
use yii\web\AssetBundle;

class ProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/profile/index.js',
    ];

    public $depends = [
        BasicAsset::class,
        PaintingMasonryAsset::class,
    ];

}