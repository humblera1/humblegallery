<?php

use yii\web\View;

/**
 * @var View $this
 * @var array $statistics
 */

$this->title = Yii::$app->name;

?>

<div class="main">
    <?= $this->render('includes/_preview'); ?>

    <?= $this->render('includes/_benefits'); ?>

    <?= $this->render('includes/_statistics', ['statistics' => $statistics]); ?>

    <?= $this->render('includes/_artists'); ?>

    <?= $this->render('includes/_gallery'); ?>

    <?= $this->render('includes/_cta'); ?>
</div>
