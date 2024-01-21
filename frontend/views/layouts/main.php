<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
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
            <nav class="header__navigation">
                <div class="nav-block">
                    <div class="nav-item--logo"></div>
                    <div class="nav-item">Художники</div>
                    <div class="nav-item">Картины</div>
                    <div class="nav-item">Статьи</div>
                </div>
                <div class="nav-block">
                    <div class="nav-item">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <?php $text = "<i class='fa-solid fa-right-to-bracket'></i>    Вход"; ?>
                            <div class='' id='login-button'>
                                <p><i class='fa-solid fa-right-to-bracket'></i>   Вход</p>
                            </div>
                        <?php else: ?>
                            <?= Html::a('Профиль', ['/user/personal-area', 'id' => Yii::$app->user->id], ['class' => 'nav-item']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </header>
        <div class="page-container">
            <?= $content ?>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        </div>
    </div>
</div>

<?php if (Yii::$app->user->isGuest): ?>

    <div id="overlay"> </div>
    <div id="login-modal" class="modal">
        <div class="modal__wrapper">
            <div class="modal__content">
                <div class="modal__header">
                    <div class="modal-head">
                        <div class="modal-head--close">
                            <div class="close-button">×</div>
                        </div>
                        <div class="modal-head--title">
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
