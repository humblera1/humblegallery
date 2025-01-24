<?php

use common\modules\artist\models\data\Artist;
use common\widgets\SwiperWidget;

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
            <?= SwiperWidget::widget([
                'paintings' => $model->service->getTopRatedPaintings(),
            ]) ?>
        </section>
    </div>
</div>
