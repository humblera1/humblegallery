<?php

use common\helpers\Html;
use common\modules\collection\models\form\AddPaintingToNewCollectionForm;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var AddPaintingToNewCollectionForm $model
 * @var int $paintingId
 */

?>

<div class="modal-collections__form">
    <?php $form = ActiveForm::begin([
        'id' => 'collection-form',
        'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
        'enableAjaxValidation' => true,
        'validationUrl' => '/collections/validate-form',
        'action' => '/collections/create-and-add',
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_private')->checkbox() ?>

    <?= $form->field($model, 'painting_id')->hiddenInput(['value' => $paintingId])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn_orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
