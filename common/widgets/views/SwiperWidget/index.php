<?php

use common\helpers\Html;
use common\modules\painting\models\data\Painting;

/**
 * @var $paintings Painting[]
 */

?>

<div id="swiper-widget">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($paintings as $painting): ?>
                <a class="swiper-slide" href="<?= '/paintings/' . $painting->getSelfHealingUrl() ?>">
                    <img src="<?= $painting->service->getImage() ?>" alt="painting">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="swiper-button-next">
        <?= Html::icon('chevron') ?>
    </div>
</div>
