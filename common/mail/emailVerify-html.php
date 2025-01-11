<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $verifyLink
 * @var string $username
 */

?>
<div class="verify-email">
    <p>Привет, <?= Html::encode($username) ?>!</p>

    <p>Для подтверждения почты необходимо перейти по ссылке:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
