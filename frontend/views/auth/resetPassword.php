<?php

use common\modules\user\models\forms\ResetPasswordForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var ResetPasswordForm $model
 */

$this->title = 'Сброс пароля';
$this->params['image'] = 'reset-password.png';
?>
<div class="reset-password">
    <p class="reset-password__subtitle">Придумайте новый пароль:</p>

    <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'options' => ['class' => 'reset-password__form']]); ?>

    <div class="reset-password__body">
        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'passwordAgain')->passwordInput() ?>
    </div>

    <div class="reset-password__footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn_orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
