<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ProfileNavbarBundle extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/profile/navbar.js',
    ];

    public $depends = [
        AppAsset::class,
    ];
}