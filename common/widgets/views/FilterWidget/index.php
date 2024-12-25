<?php

use common\helpers\Html;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

/**
 * @var $searchModel ActiveRecord
 * @var $models ActiveRecord[]
 */

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
                'id' => 'painting-form',
                'action' => "filtering",
            ]);
            ?>
            <?php foreach ($models as $model): ?>
                <?= $this->render('includes/_section', ['searchModel' => $searchModel, 'model' => $model]) ?>
            <?php endforeach; ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</aside>
