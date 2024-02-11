<?php

use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 */

?>

<?= ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '@common/views/_painting',
]); ?>

