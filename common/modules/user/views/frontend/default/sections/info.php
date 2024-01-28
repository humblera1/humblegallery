<?php

use common\modules\user\models\forms\EditForm;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var EditForm $model
 */

$model = new EditForm();

?>

<div id="info">
    <?php $form = ActiveForm::begin(['id' => 'info-form', 'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT]) ?>
        <div class="info-header">
            <div class="info-header__profile-image">
            </div>
            <div class="info-header__profile-name">
                Максим Кошкин
            </div>
        </div>
        <div class="info-form">
            <div class="info-form__column">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            <div class="info-form__column">
                <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
