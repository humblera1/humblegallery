<?php

use common\components\widgets\LinkPager;
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
    'layout' => "<div class='artists__list'>{items}</div>\n{pager}",
    'itemView' => '@common/views/_artist-card',
    'options' => [
        'class' => 'artists__container',
    ],
    'pager' => [
        'class' => LinkPager::class,
    ],
]); ?>
