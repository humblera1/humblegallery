<?php

use common\helpers\Html;
use common\modules\collection\models\data\Collection;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Collection $model
 */

$title = $model->isNewRecord ? 'Создание коллекции' : 'Редактирование коллекции';
$hasCover = $model->cover;
$toggleName = "{$model->formName()}[is_private]";

?>

<?php $form = ActiveForm::begin([
    'id' => 'collection-form',
    'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
    'enableAjaxValidation' => true,
    'validationUrl' => '/collections/validate-edit',
    'method' => 'post',
    'options' => [
        'class' => 'modal-collections__form',
        'enctype' => 'multipart/form-data',
    ],
]); ?>

<div class="modal-collections__header">
    <h3 class="modal-collections__title"><?= $title ?></h3>
</div>
<div class="modal-collections__body">
    <div class="modal-collections__container">
        <div id="collections-preview" class="modal-collections__preview">
            <div class="modal-collections__plus">
                <?= Html::icon('plus') ?>
            </div>
            <?php if ($hasCover): ?>
                <img src="<?= $model->service->getCover(); ?>" alt="Cover">
            <?php endif; ?>
        </div>

        <div id="preview-actions" class="modal-collections__actions <?= $hasCover ? 'visible' : '' ?>">
            <span id="refresh-action" class="modal-collections__refresh">
                <?= Html::icon('refresh'); ?>
            </span>
            <span id="delete-action" class="modal-collections__delete">
                <?= Html::icon('trash'); ?>
            </span>
        </div>
        <?= $form->field($model, 'remove_cover')->hiddenInput(['id' => 'cover-delete-input'])->label(false) ?>

        <?= $form->field($model, 'file')->fileInput(['style' => 'display: none;', 'id' => 'cover-input'])->label(false) ?>
    </div>
    <div id="collections-content" class="modal-collections__content">
        <div class="modal-collections__fields">
            <?= $form->field($model, 'title', [
                'options' => [
                    'class' => 'form-group form-group_vertical',
                ],
            ])->textInput(['maxlength' => true]) ?>

            <div class="toggle">
                <!-- Hidden input to ensure a value is always sent -->
                <input type="hidden" name="<?= $toggleName ?>" value="0">

                <!-- Checkbox input -->
                <input id="toggle-is-private" class="toggle__input" type="checkbox" name="<?= $toggleName ?>"
                       value="1" <?= $model->is_private ? 'checked' : '' ?>>
                <label for="toggle-is-private" class="toggle__switch"></label>
                <span class="toggle__label">Секретная</span>
            </div>
        </div>
    </div>
</div>
<div class="modal-collections__footer">
    <?php if ($model->is_archived): ?>
        <?= Html::button('Восстановить', [
            'id' => 'restore-button',
            'class' => 'btn btn_brown',
        ]) ?>
    <?php else: ?>
        <?= Html::button('Удалить', [
            'id' => 'delete-button',
            'class' => 'btn btn_red',
        ]) ?>
    <?php endif; ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn_orange']) ?>
</div>

<?php ActiveForm::end(); ?>
