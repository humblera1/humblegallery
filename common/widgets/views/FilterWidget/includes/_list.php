<?php

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * @var $searchModel ActiveRecord
 * @var $model ActiveRecord
 */

$pluralForm = Inflector::pluralize($model::tableName());
$inputName = "{$searchModel->formName()}[$pluralForm][]";

$items = ArrayHelper::map($model::find()->orderBy('name')->all(), 'id', 'name');

?>

<div class="filter-section__list">
    <?php foreach ($items as $id => $name): ?>
        <div class="filter-item">
            <input type="checkbox" id="checkbox-<?= $id ?>" name="<?= $inputName ?>" value="<?= $id ?>" class="filter-item__checkbox">
            <label for="checkbox-<?= $id ?>" class="filter-item__box">
                <span class="filter-item__circle" style="display: none;"></span>
            </label>
            <span class="filter-item__label">
            <?= $name ?>
        </span>
        </div>
    <?php endforeach; ?>
</div>
<?php if (count($items) > 4): ?>
    <div class="filter-section__basement">
        <span id="open-filter"> ещё... </span>
    </div>
<?php endif; ?>




