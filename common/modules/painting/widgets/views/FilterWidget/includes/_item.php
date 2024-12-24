<?php
/**
 * @var $index int
 * @var $label string
 * @var $name string
 * @var $checked bool
 * @var $value int
 */
?>

<div class="filter-item">
    <input type="checkbox" id="checkbox-<?= $index ?>" name="<?= $name ?>" value="<?= $value ?>" <?= $checked ? 'checked' : '' ?> class="filter-item__checkbox">
    <label for="checkbox-<?= $index ?>" class="filter-item__box">
        <span class="filter-item__circle" style="display: <?= $checked ? 'block' : 'none' ?>"></span>
    </label>
    <span class="filter-item__label">
        <?= $label ?>
    </span>
</div>

