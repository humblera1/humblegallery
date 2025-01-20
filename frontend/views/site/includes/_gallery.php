<?php

use common\widgets\MasonryWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 */

?>

<div class="main-gallery">
    <h2 class="main__title">Картинная галерея</h2>
    <div class="main-gallery__content">
        <?= MasonryWidget::widget(['provider' => $provider]) ?>
    </div>
</div>