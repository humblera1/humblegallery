<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 */

?>

<div class="main-benefits">
    <div class="main-benefits__image">
        <img src="/images/benefits.png" alt="">
    </div>
    <div class="main-benefits__content">
        <h2 class="main__title">Что мы можем предложить?</h2>
        <div class="main-benefits__cards">
            <div class="main-benefits__card">
                <div class="main-benefits__badge">
                    <?= Html::icon('palette'); ?>
                </div>
                <div class="main-benefits__info">
                    <h3 class="main-benefits__subtitle">
                        Изучайте мастеров
                    </h3>
                    <p class="main-benefits__text">
                        Познакомьтесь с биографией знаменитых художников, переходя по карточкам
                    </p>
                </div>
            </div>
            <div class="main-benefits__card">
                <div class="main-benefits__badge">
                    <?= Html::icon('mountains'); ?>
                </div>
                <div class="main-benefits__info">
                    <h3 class="main-benefits__subtitle">
                        Знакомьтесь с картинами
                    </h3>
                    <p class="main-benefits__text">
                        Откройте для себя шедевры мирового искусства, изучая историю картин
                    </p>
                </div>
            </div>
            <div class="main-benefits__card">
                <div class="main-benefits__badge">
                    <?= Html::icon('grid-plus'); ?>
                </div>
                <div class="main-benefits__info">
                    <h3 class="main-benefits__subtitle">
                        Создавайте собственные коллекции
                    </h3>
                    <p class="main-benefits__text">
                        Собирайте и сохраняйте любимые произведения искусства в персональные коллекции
                    </p>
                </div>
                <div class="main-benefits__collection">
                    <img src="/images/benefit-card.png" alt="Collection Abstract Image">
                </div>
            </div>
        </div>
    </div>
</div>