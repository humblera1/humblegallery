<?php

use common\modules\movement\models\data\Movement;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var $model ActiveRecord
 */
?>

<div class="filter-section">
    <div class="filter-section__caption">
        <p class="filter-section__title">Жанры</p>
        <div class="filter-section__actions">
            <div class="filter-section__badge">
                <span> 0 </span>
            </div>
            <div class="filter-section__minus">
                <span> - </span>
            </div>
        </div>
    </div>
    <div class="filters__list">
        <?= Html::activeCheckboxList(
            $model,
            'movements',
            ArrayHelper::map(Movement::find()->all(), 'id', 'name'),
            [
                'item' => function ($index, $label, $name, $checked, $value): string {
                    return $this->render('_item', compact('index', 'label', 'name', 'checked', 'value'));
                },
            ]
        ); ?>
    </div>
</div>
