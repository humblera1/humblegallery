<?php

use common\helpers\Html;
use common\modules\painting\models\data\Painting;
use yii\web\View;

/**
 * @var View $this
 * @var Painting $model
 */

$collectionsCount = (!$isGuest = Yii::$app->user->isGuest) ? $model->service->getCollectionsCountByUser() : 0;
$likedByUser = !$isGuest && $model->service->isLikedByCurrentUser();

?>

<div class="painting-card">
    <div class="painting-card__actions">
        <div class="painting-card__wrapper painting-card__wrapper_heart <?= $likedByUser ? 'liked' : '' ?>" data-painting-id="<?= $model->id ?>">
            <?= Html::icon('heart-empty') ?>
        </div>
        <div class="painting-card__wrapper painting-card__wrapper_collect" data-painting-id="<?= $model->id ?>">
            <?= Html::icon('plus') ?>
        </div>
    </div>
    <div class="painting-card__content">
        <div class="painting-card__image">
            <?= Html::img($model->service->getThumbnail(), ['class' => 'painting-card__img']); ?>
        </div>
        <div class="painting-card__info">
            <p class="painting-card__title"><?= $model->title ?></p>
            <p class="painting-card__date"><?= $model->service->getDateToDisplay() ?></p>
        </div>
    </div>
</div>

<?php

$this->registerJsVar('isGuest', Yii::$app->user->isGuest);
