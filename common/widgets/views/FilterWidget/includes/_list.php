<?php

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @var $searchModel ActiveRecord
 * @var $model ActiveRecord
 */

$inputName = $searchModel->formName() . "[" . $model::getPluralName() . "]" . "[]";
$items = ArrayHelper::map($model::find()->orderBy('name')->all(), 'id', 'name');

?>

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


