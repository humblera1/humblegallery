<?php

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var ActiveDataProvider $provider
 */
?>

<main class="content">
    <?= ListView::widget([
        'dataProvider' => $provider,
        'itemView' => '_painting',
    ]); ?>
</main>
