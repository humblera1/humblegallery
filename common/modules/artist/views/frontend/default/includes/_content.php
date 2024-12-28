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
    'layout' => "{items}\n{pager}",
    'itemView' => '@common/views/_artist',
    'options' => [
        'class' => 'artists__list',
    ],
]); ?>
