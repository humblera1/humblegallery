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

$class = $containerClass . " loading";

$this->registerCss(<<<CSS
#masonry-widget {
    opacity: 1;
    visibility: visible;
    transition: all 250ms ease;
}

#masonry-widget.loading {
    opacity: 0;
    visibility: hidden;
}
CSS);
?>

<section id='masonry-widget' class="<?= $class ?>" data-pjax-id="<?= $pjaxId ?>">
    <?php Pjax::begin(['id' => $pjaxId, 'enablePushState' => false]) ?>
    <?= ListView::widget([
        'dataProvider' => $provider,
        'layout' => "<div id='masonry-container'>{items}</div>\n{pager}",
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

