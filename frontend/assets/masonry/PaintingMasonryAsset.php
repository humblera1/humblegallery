<?php

namespace frontend\assets\masonry;

use yii\web\AssetBundle;

/**
 * Painting Masonry
 */
class PaintingMasonryAsset extends AssetBundle
{
    public $js = [
        'js/masonry/masonry-painting.js',
    ];

    public $depends = [
        MasonryAsset::class,
    ];
}