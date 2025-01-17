<?php

use common\components\widgets\FilterSection;
use common\helpers\Html;
use yii\base\Model;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Model $searchModel
 * @var FilterSection[] $sections
 */

?>

<div id="popup-filter-widget" title="Фильтры">
    <div class="filter-widget">
        <div class="filter-widget__badge">
            <?= Html::icon('controls'); ?>
        </div>
        <div class="filter-widget__popup">
            <?php $form = ActiveForm::begin([
                'id' => 'filter-widget-form',
                'options' => [
                    'class' => 'filter-widget__form',
                ],
            ]); ?>
            <div class="filter-widget__body">
                <?php foreach ($sections as $section): ?>
                    <?= $this->render('includes/_section', compact('searchModel', 'section')); ?>
                <?php endforeach; ?>
            </div>
            <div class="filter-widget__footer">
                <?= Html::submitButton('Применить', [
                    'class' => 'btn btn_orange'
                ]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>