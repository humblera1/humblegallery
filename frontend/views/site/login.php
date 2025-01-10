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
?>

<div class="login">
    <div class="login__preview">
        <img class="login__image" src="/images/login.png" alt="Login Image">
    </div>
    <section class="login__content">
        <h1 class="title">Вход</h1>
        <?php $form = ActiveForm::begin(['id' => 'login-signup', 'options' => ['class' => 'login__form']]); ?>
        <div class="login__body">
            <section class="login__section">
                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <a href="/reset-password" class="login__forgot-password">
                    Забыли пароль?
                </a>
            </section>
        </div>
        <div class="login__footer">
            <?= Html::submitButton('Войти', ['class' => 'btn btn_brown', 'name' => 'login-button']) ?>

            <p class="login__signup">
                Впервые на нашем сайте? <a href="/signup">Зарегистрируйтесь здесь!</a>
            </p>
        </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
