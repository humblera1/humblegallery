<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<?php if (Yii::$app->user->isGuest): ?>
    <div class="main-cta">
        <div class="main-cta__banner">
            <div class="main-cta__image">
                <img src="/images/cta.png" alt="CTA Image">
            </div>
            <div class="main-cta__content">
                <p class="title">Присоединяйтесь к сообществу ценителей искусства!</p>
                <div class="main-cta__buttons">
                    <a href="/auth/signup">
                        <button id='login-button' class="btn btn_orange">Регистрация</button>
                    </a>
                    <a href="/auth/login">
                        <button class="btn btn_brown">Вход</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>