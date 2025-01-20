<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 */

?>

<div class="toast toast_success">
    <div class="toast__content">
        <div class="toast__icon"><?= Html::icon('check') ?></div>
        <span class="toast__message"></span>
        <div class="toast__close"><?= Html::icon('close') ?></div>
    </div>
</div>
