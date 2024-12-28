<?php

use common\helpers\Html;
use common\modules\artist\models\data\Artist;
use yii\web\View;

/**
 * @var View $this
 * @var Artist $model
 */

?>

<a class="artist" href="<?= '/artists/' . $model->getSelfHealingUrl() ?>">
    <div class="artist__container">
        <div class="artist__circle"></div>
        <div class="artist__image">
            <?= Html::img($model->service->getImage(), ['class' => 'artist__img']); ?>
        </div>
    </div>
    <div class="artist__content">
        <div class="artist__info">
            <h2 class="artist__name">
                <?= Html::encode($model->name) ?>
            </h2>
            <p class="artist__description">
                <?= Html::encode($model->description) ?>
            </p>
        </div>
        <div class="artist__movements">
            <?php foreach($model->service->getLimitedMovementNames() as $movementName): ?>
                <div class="artist__movement">
                    <?= $movementName ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="artist__badge">
        <?= Html::icon('chevron'); ?>
    </div>
</a>
