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

$this->title = 'Подтверждение почты';
$this->params['image'] = 'resend-verification-email.png';
?>
<div class="resend-verification-email">
    <p class="resend-verification-email__subtitle">Укажите почту, на которую будет отправлено письмо для подтверждения:</p>

    <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form', 'options' => ['class' => 'resend-verification-email__form']]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <div class="resend-verification-email__footer">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn_orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
