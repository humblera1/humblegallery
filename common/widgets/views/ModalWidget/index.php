<?php

/**
 * @var string $content
 * @var string $toggleButton
 * @var string $position
 * @var bool $needToRenderOverlay
 */

?>

<?php if ($needToRenderOverlay): ?>
    <div id="modal-widget" class="<?= $position ?>">
        <div class="modal__overlay"></div>
        <div class="modal__wrapper">
            <!-- content going here -->
        </div>
    </div>
<?php endif; ?>

<div class="modal" data-toggle-button="<?= htmlspecialchars($toggleButton, ENT_QUOTES, 'UTF-8') ?>">
    <?= $content ?>
</div>
