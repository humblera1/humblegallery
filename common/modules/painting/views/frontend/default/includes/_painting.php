<?php

use common\modules\painting\models\data\Painting;
use yii\helpers\Html;


/**
 * @var Painting $model
 */

?>
<div class="paint-container">
    <div class="paint-container__actions">
        <div class="action__wrapper action__wrapper_heart" data-painting-id="<?= $model->id ?>">
            <div class="action__content">
                <?php $class = $model->service->isLikedByCurrentUser() ? 'action__icon_liked' : ''; ?>
                <i class="<?= $class ?> action__icon fa-solid fa-heart"></i>
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