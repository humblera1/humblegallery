<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class MasonryAsset extends AssetBundle
{
    public $js = [
        'js/masonry.js',
        'js/painting/painting.js',
    ];

    public $depends = [
        AppAsset::class,
    ];
}