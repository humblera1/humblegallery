<?php

use common\widgets\MasonryWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var $this View
 * @var ActiveDataProvider $provider
 */

?>

<div class="profile-favorites">
    <header class="profile-favorites__header">
        <h1 class="title">Избранное</h1>
    </header>
    <main class="profile-favorites__content">
        <?= MasonryWidget::widget(['provider' => $provider]) ?>
    </main>
</div>
