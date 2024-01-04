<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>


<div class="jumbotron text-center bg-transparent mt-5">
    <h1>Hello, <?= Yii::$app->user->identity->username ?>!</h1>
</div>
