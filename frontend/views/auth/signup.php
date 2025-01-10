<?php

use common\modules\user\models\forms\SignupForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var SignupForm $model
 */

$this->title = 'Регистрация';
$this->params['image'] = 'signup.png';
?>

<?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'signup__form']]); ?>
<div class="signup__body">
    <section class="signup__section">
        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'surname')->textInput() ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>
    </section>
    <section class="signup__section">
        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'passwordAgain')->passwordInput() ?>
    </section>
    <section class="signup__section">
        <?= $form->field(
            $model,
            'captcha',
            [
                'template' => "<div class='form-group__content'>{label}\n{input}</div>\n{error}",
                'options' => [
                    'class' => 'form-group form-group_captcha',
                ],

            ],
        )->widget(Captcha::class, [
            'captchaAction' => 'auth/captcha',
            'template' => "{input}<div class='form-group__captcha'>{image}</div>"
        ]) ?>
    </section>
</div>
<div class="signup__footer">
    <?= Html::submitButton('Продолжить', ['class' => 'btn btn_orange', 'name' => 'signup-button']) ?>
</div>
<?php ActiveForm::end(); ?>
