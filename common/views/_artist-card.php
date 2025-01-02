<?php

use common\helpers\Html;
use common\modules\artist\models\data\Artist;
use yii\web\View;

/**
 * @var View $this
 * @var Artist $model
 */

?>
<a class="artist-card" href="<?= '/artists/' . $model->getSelfHealingUrl() ?>">
    <div class="artist-card__container">
        <div class="artist-card__circle"></div>
        <div class="artist-card__image">
            <?= Html::img($model->service->getImage(), ['class' => 'artist-card__img']); ?>
        </div>
    </div>
    <div class="artist-card__content">
        <div class="artist-card__info">
            <h2 class="artist-card__name">
                <?= Html::encode($model->name) ?>
            </h2>
            <p class="artist-card__description">
                <?= Html::encode($model->description) ?>
            </p>
        </div>
        <div class="artist-card__movements">
            <?php foreach($model->service->getLimitedMovementNames() as $movementName): ?>
                <div class="artist-card__movement">
                    <?= $movementName ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="artist-card__badge">
        <?= Html::icon('chevron'); ?>
    </div>
</a>
