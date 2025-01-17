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
<a class="card" href="<?= '/paintings/' . $model->getSelfHealingUrl() ?>">
    <div class="card__actions">
        <div class="card__wrapper card__wrapper_heart <?= $likedByUser ? 'liked' : '' ?>" data-painting-id="<?= $model->id ?>">
            <?= Html::icon('heart-empty') ?>
        </div>
        <div class="card__wrapper card__wrapper_collect" data-painting-id="<?= $model->id ?>">
            <?= Html::icon('plus') ?>
        </div>
    </div>
    <div class="card__content">
        <div class="card__image">
            <?= Html::img($model->service->getThumbnail(), ['class' => 'card__img']); ?>
        </div>
        <div class="card__info">
            <p class="card__title"><?= $model->title ?></p>
            <p class="card__date"><?= $model->service->getDateToDisplay() ?></p>
        </div>
    </div>
</a>
