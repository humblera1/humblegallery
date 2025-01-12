<?php

use common\widgets\ProfileNavWidget;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

?>

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div class="profile">
    <aside class="profile__aside">
        <header class="profile__header">
            <div class="profile__avatar">
                <img src="" alt="">
            </div>
            <div class="profile__info">
                <p class="profile__name">Максим Кошкин</p>
                <p class="profile__email">koshkin@mail.ru</p>
            </div>
        </header>
        <div class="profile__navigation">
            <!-- виджет навигации -->
            <?= ProfileNavWidget::widget() ?>
        </div>
    </aside>
    <div class="profile__content">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent(); ?>