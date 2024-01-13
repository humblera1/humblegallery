<?php

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var ActiveDataProvider $provider
 */
?>

<?= ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_painting',
]); ?>

