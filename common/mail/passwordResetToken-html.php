<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $username
 * @var string $resetLink
 */

?>
<div class="password-reset">
    <p>Привет, <?= Html::encode($username) ?>!</p>

    <p>Для сброса пароля необходимо перейти по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
