<?php

use common\helpers\Html;
use common\widgets\ProfileNavWidget;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

$user = Yii::$app->user->identity;

$isOwner = $user && ($user->username === Yii::$app->request->get('username'));

?>

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div class="profile">
    <aside class="profile__aside">
        <?php if ($isOwner): ?>
            <header class="profile__header">
                <div class="profile__avatar">
                    <?php if ($user->avatar): ?>
                        <img src="<?= $user->service->getAvatar(); ?>" alt="Avatar">
                    <?php endif; ?>

                    <?= Html::icon('avatar-placeholder'); ?>
                </div>
                <div class="profile__info">
                    <p class="profile__name"><?= $user->service->getName(); ?></p>
                    <p class="profile__email"><?= $user->email; ?></p>
                </div>
            </header>
        <?php endif; ?>
        <div class="profile__navigation">
            <?= ProfileNavWidget::widget() ?>
        </div>
    </aside>
    <div class="profile__content">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent(); ?>