<?php

use common\modules\user\models\forms\PasswordResetRequestForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var PasswordResetRequestForm $model
 */

$this->title = 'Сброс пароля';
$this->params['image'] = 'reset-password.png';
?>

<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'options' => ['class' => 'request-password-reset']]); ?>

<div class="request-password-reset__body">
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
</div>

<div class="request-password-reset__footer">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn_orange', 'name' => 'request-password-reset-button']) ?>
</div>

<?php ActiveForm::end(); ?>
