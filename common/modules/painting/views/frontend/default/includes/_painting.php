<?php

use common\modules\painting\models\data\Painting;
use yii\helpers\Html;


/**
 * @var Painting $model
 */

?>
<div class="paint-container">
    <div class="paint-content">

        <div class="paint-content__image-wrapper">
            <?= Html::img($model->service->getThumbnail(), ['class' => 'paint-content__image']); ?>
        </div>

        <div class="paint-content__title">
            <?= $model->service->getNameToDisplay() ?>
        </div>

    </div>
</div>