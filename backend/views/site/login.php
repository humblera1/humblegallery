<?php

use common\models\LoginForm;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/**
 * @var LoginForm $model
 */

$this->title = 'Вход';
?>


<div class="login-box-body">
    <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

    <?= $form->field($model, 'username')->textInput([
        'placeholder' => $model->getAttributeLabel('username'),
    ])->label(false) ?>

    <?= $form->field($model, 'password')->passwordInput([
        'placeholder' => $model->getAttributeLabel('password'),
    ])->label(false) ?>

    <?= Html::submitButton('Войти', ['class' => 'btn btn-orange']) ?>

    <?php ActiveForm::end() ?>
</div>
