<?php

use common\helpers\Html;
use common\modules\painting\models\data\Painting;
use yii\web\View;

/**
 * @var View $this
 * @var Painting $model
 */

$likedByUser = !Yii::$app->user->isGuest && $model->service->isLikedByCurrentUser();

?>

<a class="painting-card" href="<?= '/paintings/' . $model->getSelfHealingUrl() ?>">
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
</a>
