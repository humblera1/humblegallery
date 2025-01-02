<?php

use common\modules\artist\models\data\Artist;

/**
 * @var $model Artist
 */

?>

<div class="artist">
    <div class="artist__head">
        <section class="artist__preview">
            <div class="artist__image">
                <img src="<?= $model->service->getImage() ?>" alt="artist-image">
            </div>
            <div class="artist__circle"></div>
        </section>
        <section class="artist__info">
            <div>
                <h1 class="artist__name">
                    <?= $model->name ?>
                </h1>
                <p class="artist__years">
                    <?= $model->service->getYears() ?>
                </p>
                <p class="artist__description">
                    <?= $model->description ?>
                </p>
            </div>
            <div id="swiper-widget" class="artist__swiper swiper-container">
                <div class="swiper-wrapper">
                    <!-- Add your swiper slides here -->
                    <div class="swiper-slide">Slide 1</div>
                    <div class="swiper-slide">Slide 2</div>
                    <div class="swiper-slide">Slide 3</div>
                    <div class="swiper-slide">Slide 4</div>
                    <div class="swiper-slide">Slide 5</div>

                    <!-- ... -->
                </div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
            </div>
        </section>
    </div>
    <div class="artist__body">
        <h2 class="artist__title">
            О художнике
        </h2>
        <p class="artist__about">
            <?= $model->description ?>
        </p>
    </div>
</div>
