<?php


use common\modules\user\models\forms\LoginForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var LoginForm $model
 */

?>

<div class="">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(
                [
                    'id' => 'login-form',
                    'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
                    'enableAjaxValidation' => true,
                    'validationUrl' => "/user/validate-login",
                ]
            ); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="my-1 mx-0" style="color:#999;">
                <?= Html::a('Забыли пароль?', ['site/request-password-reset']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-orange', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('#login-form').on('beforeSubmit', function (event) {
    const sendForm = $.ajax(
        {
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serializeArray()
        }
    );

    sendForm.done(function(data) {
        console.log('yay!');
    });

    sendForm.fail(function () {
        console.log('ошибка при отправке формы входа');
    });

    return false;
})
JS;
?>
