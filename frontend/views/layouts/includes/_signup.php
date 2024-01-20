<?php

use common\modules\user\models\forms\SignupForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var SignupForm $model
 */

?>

<div class="">
    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(
                [
                    'id' => 'signup-form',
                    'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
                    'enableAjaxValidation' => true,
                    'validationUrl' => "validate-signup",
                ]
            ); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
