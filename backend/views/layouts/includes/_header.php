<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="main-header">
    <nav class="navbar navbar-expand block">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= Url::home() ?>" class="nav-link">Главная</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?= Html::a(Yii::$app->user->identity->username, ['/'], ['class' => 'nav-link']) ?>
            </li>
            <li class="nav-item">
                <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
            </li>
        </ul>
    </nav>
</div>

