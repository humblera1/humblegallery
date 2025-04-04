<?php

use common\components\widgets\FilterSection;
use common\helpers\Html;
use yii\base\Model;
use yii\web\View;

/**
 * @var View $this
 * @var Model $searchModel
 * @var FilterSection $section
 */

$isActive = false;

$baseName = "{$searchModel->formName()}[$section->attribute]";

$name = $section->multiple ? $baseName . '[]' : $baseName;
$type = $section->multiple ? 'checkbox' : 'radio';

$expandable = count($section->items) > 3;

$isActive = function(mixed $value) use ($searchModel, $section): bool {
    if (isset($section->selected)) {
        return $section->selected === $value;
    }

    return $searchModel->{$section->attribute} === $value;
};
?>

<fieldset class="filter-widget__section" data-multiple="<?= $section->multiple ? 'true' : 'false' ?>">
    <legend class="filter-widget__title">
        <?= $searchModel->getAttributeLabel($section->attribute); ?>
    </legend>
    <div class="filter-widget__list">
        <?php foreach ($section->items as $value => $item): ?>
            <label class="filter-widget__item <?= $isActive($value) ? 'active' : '' ?>">
                <input class="filter-widget__input" type="<?= $type ?>" name="<?= $name ?>" value="<?= $value ?>" <?= $isActive($value) ? 'checked' : '' ?> />
                <span class="filter-widget__label" ><?= $item ?></span>
                <span class="filter-widget__check">
                    <?= Html::icon('check'); ?>
                </span>
            </label>
        <?php endforeach; ?>
    </div>
    <?php if($expandable): ?>
        <section class="filter-widget__action">
            <span class="filter-widget__expand">ещё...</span>
        </section>
    <?php endif; ?>
</fieldset>
