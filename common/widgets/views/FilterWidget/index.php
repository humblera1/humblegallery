<?php

use common\helpers\Html;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

/**
 * @var $searchModel ActiveRecord
 * @var array<string, ActiveRecord> $filters
 */

//$len = count($models);

?>

<aside id="filter-widget">
    <div class="filters">
        <div class="filters__header">
            <div class="filters__icon">
                <?= Html::icon('funnel'); ?>
            </div>
            <p class="filters__title"> Фильтры </p>
        </div>
        <div class="filters__body">
            <?php $form = ActiveForm::begin([
                'id' => 'filter-widget-form',
                'options' => [
                    'data-pjax' => true,
                ],
            ]);
            ?>
            <?php foreach ($filters as $title => $model): ?>
                <?= $this->render('includes/_section', compact('searchModel', 'title', 'model')); ?>
                <?php if (true): ?>
                    <div class="filters__separator"></div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="filters__footer">
            <button type="submit" form="filter-widget-form" class="btn btn_orange btn_full">Применить</button>
            <button type="button" id="reset-all-filters" class="btn btn_light-orange btn_full">Сбросить</button>
        </div>
    </div>
</aside>
