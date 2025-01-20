<?php

use yii\web\View;

/**
 * @var View $this
 */

$this->title = Yii::$app->name;

?>

<div class="main">
    <?= $this->render('includes/_preview'); ?>

    <?= $this->render('includes/_benefits'); ?>

    <?= $this->render('includes/_statistics'); ?>

    <?= $this->render('includes/_artists'); ?>

    <?= $this->render('includes/_gallery'); ?>

    <?= $this->render('includes/_cta'); ?>
</div>
