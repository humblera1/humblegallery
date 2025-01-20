<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var array $flashes
 */

?>

<div id="flash-message">
    <div class="flash-message" style="display: none;">
        <div class="flash-message__overlay"></div>
        <div class="flash-message__wrapper">
            <div class="flash-message__close">
                <?= Html::icon('close') ?>
            </div>
            <div class="flash-message__badge flash-message__badge_success">
                <?= Html::icon('check') ?>
            </div>
            <div class="flash-message__badge flash-message__badge_error">
                <?= Html::icon('close') ?>
            </div>
            <div class="flash-message__content">
                <div class="flash-message__info">
                    <p class="flash-message__title"></p>
                    <p class="flash-message__message"></p>
                </div>
                <div class="flash-message__footer"></div>
            </div>
        </div>
    </div>
</div>

<?= Html::tag('div', json_encode($flashes), ['id' => 'flash-data', 'style' => 'display:none;']); ?>
