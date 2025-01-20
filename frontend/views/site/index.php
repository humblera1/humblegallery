<?php

use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var array $statistics
 * @var ActiveDataProvider $artistsDataProvider
 * @var ActiveDataProvider $paintingsDataProvider
 */

$this->title = Yii::$app->name;

?>

<div class="main">
    <?= $this->render('includes/_preview'); ?>

    <?= $this->render('includes/_benefits'); ?>

    <?= $this->render('includes/_statistics', ['statistics' => $statistics]); ?>

    <?= $this->render('includes/_artists', ['provider' => $artistsDataProvider]); ?>

    <?= $this->render('includes/_gallery', ['provider' => $paintingsDataProvider]); ?>

    <?= $this->render('includes/_cta'); ?>
</div>
