<?php

use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 */

?>

<div class="main-artists">
    <h2 class="main__title">Популярные художники</h2>
    <div class="main-artists__content">
        <?= ListView::widget([
            'dataProvider' => $provider,
            'layout' => "{items}\n{pager}",
            'itemView' => '@common/views/_artist-card',
            'options' => [
                'class' => 'main-artists__list',
            ],
        ]); ?>
    </div>
</div>