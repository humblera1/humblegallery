<?php

use common\modules\movement\models\data\Movement;
use common\modules\painting\models\search\PaintingSearch;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model PaintingSearch
 */

?>

<div class="sidebar">
    <aside class="filters-modal">
        <div class="filters-modal-body">
            <?php $form = ActiveForm::begin([
                'id' => 'painting-form',
                'action' => "filtering",
            ]);
            ?>
            <div class="painting-filter__block">
                <div class="painting-filter__block--title">Жанры</div>
                <?= Html::activeCheckboxList(
                    $model,
                    'subjects',
                    ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
                    [
                        'tag' => 'div class="painting-filter__block--item"',
                        'itemOptions' => [
                            'class' => 'filter',
                        ],
                    ]
                ); ?>
            </div>
            <div class="painting-filter__block">
                <div class="painting-filter__block--title">Техники</div>
                <?= Html::activeCheckboxList(
                    $model,
                    'techniques',
                    ArrayHelper::map(Technique::find()->all(), 'id', 'name'),
                    [
                        'tag' => 'div class="painting-filter__block--item"',
                        'itemOptions' => [
                            'class' => 'filter',
                        ],
                    ]
                ); ?>
            </div>
            <div class="painting-filter__block">
                <div class="painting-filter__block--title">Направления</div>
                <?= Html::activeCheckboxList(
                    $model,
                    'movements',
                    ArrayHelper::map(Movement::find()->all(), 'id', 'name'),
                    [
                        'tag' => 'div class="painting-filter__block--item"',
                        'itemOptions' => [
                            'class' => 'filter',
                        ],
                    ]
                ); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </aside>
</div>

