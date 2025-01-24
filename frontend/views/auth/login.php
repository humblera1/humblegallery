<?php

use common\modules\user\models\forms\LoginForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var LoginForm $model
 */

$this->title = 'Вход';
$this->params['image'] = 'login.png';
?>

<?php $form = ActiveForm::begin(['id' => 'login-signup', 'options' => ['class' => 'login__form']]); ?>
<div class="login__body">
    <section class="login__section">
        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <a href="/auth/request-password-reset" class="login__forgot-password">
            Забыли пароль?
        </a>
    </section>
</div>
<div class="login__footer">
    <?= Html::submitButton('Войти', ['class' => 'btn btn_brown', 'name' => 'login-button']) ?>

    <p class="login__signup">
        Впервые на нашем сайте? <a href="/auth/signup">Зарегистрируйтесь здесь!</a>
    </p>
</div>
<?php ActiveForm::end(); ?>
