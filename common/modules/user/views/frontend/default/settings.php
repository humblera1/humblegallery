<?php

use common\helpers\Html;
use common\modules\user\models\forms\SettingsForm;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $this View
 * @var $model SettingsForm
 */

$toggleName = "{$model->formName()}[is_closed]";
$action = Yii::$app->urlManager->createUrl([
    'user/default/settings',
    'username' => Yii::$app->user->identity->username,
]);

?>

<div class="profile-settings">
    <header class="profile-settings__header">
        <h1 class="title">Настройки</h1>
    </header>
    <main class="profile-favorites__content">
        <?php $form = ActiveForm::begin([
            'id' => 'settings-form',
            'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
            'enableAjaxValidation' => true,
            'validationUrl' => '/users/validate-settings',
            'action' => $action,
            'method' => 'post',
            'options' => [
                'class' => 'profile-settings__form',
            ],
        ]); ?>

        <div class="toggle">
            <input type="hidden" name="<?= $toggleName ?>" value="0">
            <input id="toggle-is-private" class="toggle__input" type="checkbox" name="<?= $toggleName ?>"
                   value="1" <?= $model->is_closed ? 'checked' : '' ?>>
            <label for="toggle-is-private" class="toggle__switch"></label>
            <span class="toggle__label"><?= $model->getAttributeLabel('is_closed') ?></span>
        </div>

        <?php ActiveForm::end(); ?>
    </main>
    <div class="profile-settings__footer">
        <?= Html::submitButton('Сохранить', [
            'id' => 'settings-submit',
            'class' => 'btn btn_brown',
        ]) ?>
    </div>
</div>
