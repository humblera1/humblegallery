<?php

use common\components\widgets\LinkPager;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 * @var string $containerClass
 * @var string $itemView
 * @var string $pjaxId
 */

?>

<section id='masonry-widget' class="<?= $containerClass ?>" data-pjax-id="<?= $pjaxId ?>">
    <?php Pjax::begin(['id' => $pjaxId, 'enablePushState' => false]) ?>
    <?= ListView::widget([
        'dataProvider' => $provider,
        'layout' => "{items}\n{pager}",
        'itemView' => $itemView,
        'options' => [
            'class' => 'masonry__content',
        ],
        'pager' => [
            'class' => LinkPager::class,
        ],
    ]); ?>
    <?php Pjax::end() ?>
</section>

<?php if (!Yii::$app->user->isGuest): ?>
    <?= $this->render('includes/_modal') ?>
<?php endif; ?>

