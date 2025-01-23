<?php

/**
 * @var View $this
 * @var string $content
 */

use common\helpers\Html;
use common\widgets\FlashWidget;
use common\widgets\ToastWidget;
use frontend\assets\FrontendAsset;

use yii\web\View;

FrontendAsset::register($this);

$this->registerJsVar('isGuest', Yii::$app->user->isGuest);

$profileUrl = Yii::$app->urlManager->createUrl(['/user/default/view', 'username' => Yii::$app->user->identity?->username]);

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
                <a class="navigation__item navigation__item_logo" href="<?= Yii::$app->getHomeUrl() ?>">
                    лого!!!
                </a>
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
                    <a class="navigation__item navigation__item_avatar" href="<?= $profileUrl ?>">
                        <span class="navigation__avatar">
                            <?php if (Yii::$app->user->identity->avatar): ?>
                                <img src="<?= Yii::$app->user->identity->service->getAvatar() ?>" alt="avatar">
                            <?php else: ?>
                                <span class="navigation__preview">
                                    <?= Html::icon('avatar-placeholder'); ?>
                                </span>
                            <?php endif; ?>
                        </span>
                        <span class="navigation__username">
                            <?= Yii::$app->user->identity->username ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </header>
        <div class="page-container">
            <?= $content ?>
            <?= FlashWidget::widget(); ?>
            <?= ToastWidget::widget(); ?>
        </div>
        <footer class="footer">
            <p class="footer__humblerat">humblerat</p>
            <p class="footer__date"><?= date('Y') ?></p>
        </footer>
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
