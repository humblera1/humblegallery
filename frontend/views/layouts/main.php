<?php

/**
 * @var View $this
 * @var string $content
 */

use common\widgets\Alert;
use frontend\assets\FrontendAsset;
use yii\bootstrap5\Html;
use yii\web\View;

FrontendAsset::register($this);

$this->registerJsVar('isGuest', Yii::$app->user->isGuest);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="page">
    <div class="page__content">
        <header class="header">
            <nav class="navigation">
                <div class="navigation__item navigation__item_logo">лого!!!</div>
                <a class="navigation__item" href="/about">О нас</a>
                <a class="navigation__item" href="/artists">Художники</a>
                <a class="navigation__item" href="/paintings">Картины</a>
            </nav>
            <div class="auth">
                <?php if (Yii::$app->user->isGuest): ?>
                    <div class="auth__actions">
                        <a href="/auth/signup">
                            <button id='login-button' class="btn btn_orange">Регистрация</button>
                        </a>
                        <a href="/auth/login">
                            <button class="btn btn_brown">Вход</button>
                        </a>
                    </div>
                <?php else: ?>
                    <?= Html::a('Профиль', ['/profile'], ['class' => 'nav-item']); ?>
                <?php endif; ?>
            </div>
        </header>
        <div class="page-container">
            <?= $content ?>

        <?= Alert::widget() ?>
        </div>
    </div>
</div>

<?php if (Yii::$app->user->isGuest): ?>
    <div id="overlay"> </div>
    <div id="login-modal" class="modal">
        <div class="modal__wrapper">
            <div class="modal__content modal__content_login">
                <div class="modal__header">
                    <div class="modal-head">
                        <div class="modal-head__close">
                            <div class="close-button">×</div>
                        </div>
                        <div class="modal-head__title">
                            <span>
                                <span id="action-login" class="action-login action-active" data-action="login">Вход</span>
                                /
                                <span id="action-signup" class="action-signup" data-action="signup">Регистрация</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal__body">
                    <div id="login-content" class="modal__body-content">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
