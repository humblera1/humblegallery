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

<?php $form = ActiveForm::begin([
    'id' => 'collection-form',
    'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
    'enableAjaxValidation' => true,
    'validationUrl' => '/collections/validate-form',
    'action' => '/collections/create-and-add',
    'options' => [
        'class' => 'modal-collections__form',
    ],
]); ?>

<div class="modal-collections__fields">
    <?= $form->field($model, 'title', [
        'options' => [
            'class' => 'form-group form-group_vertical',
        ],
    ])->textInput(['maxlength' => true]) ?>

    <div class="toggle">
        <input id="toggle-is-private" class="toggle__input" type="checkbox" name="AddPaintingToNewCollectionForm[is_private]" value="1" <?= $model->is_private ? 'checked' : '' ?>>
        <label for="toggle-is-private" class="toggle__switch"></label>
        <span class="toggle__label">Сделать секретной</span>
    </div>

    <?= $form->field($model, 'painting_id')->hiddenInput(['value' => $paintingId])->label(false) ?>
</div>

<div class="modal-collections__footer">
    <?= Html::submitButton('Создать', ['class' => 'btn btn_orange']) ?>
</div>

<?php ActiveForm::end(); ?>
