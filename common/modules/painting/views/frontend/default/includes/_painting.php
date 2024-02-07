<?php

use common\modules\painting\models\data\Painting;
use yii\helpers\Html;


/**
 * @var Painting $model
 */

$isGuest = Yii::$app->user->isGuest;


?>
<div class="paint-container">
    <div class="paint-container__actions">
        <div class="action__wrapper action__wrapper_heart" data-painting-id="<?= $model->id ?>">
            <div class="action__content">
                <?php $class = (!$isGuest && $model->service->isLikedByCurrentUser()) ? 'action__icon_liked' : '' ?>
                    <i class="<?= $class ?> action__icon fa-solid fa-heart"></i>
            </div>
        </div>
        <div class="action__wrapper action__wrapper_collect" data-painting-id="<?= $model->id ?>" data-painting-title="<?= $model->title ?>">
            <div class="action__content">
                <?php $icon = (!$isGuest && $model->service->isCollectedByCurrentUser()) ? 'check' : 'plus'; ?>
                <i class="action__icon fa-solid fa-<?= $icon ?>"></i>
            </div>
        </div>
    </div>
    <div class="paint-content">

        <div class="paint-content__image-wrapper">
            <?= Html::img($model->service->getThumbnail(), ['class' => 'paint-content__image']); ?>
        </div>

        <div class="paint-content__title">
            <?= $model->service->getNameToDisplay() ?>
        </div>
    </div>
</div>

<?php

$this->registerJsVar('isGuest', Yii::$app->user->isGuest);