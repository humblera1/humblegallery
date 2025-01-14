<?php

use common\helpers\Html;
use common\modules\collection\models\data\Collection;
use yii\web\View;

/**
 * @var View $this
 * @var Collection $model
 * @var bool $isOwner
 */

$firstPaintings = $model->firstPaintingsWithLimit;

$url = Yii::$app->urlManager->createUrl([
    'user/default/collection-view',
    'username' => Yii::$app->request->get('username'),
    'slugHash' => $model->getSelfHealingUrl(),
]);

?>

<a href="<?= $url ?>" class="collection-card" data-collection-id="<?= $model->id ?>" >
    <div class="collection-card__content">
        <?php if ($model->cover): ?>
            <div class="collection-card__cover">
                <img src="<?= $model->service->getCover() ?>" alt="Collection Cover">
            </div>
        <?php else: ?>
            <div class="collection-card__preview">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="collection-card__item">
                        <?php if (isset($firstPaintings[$i])): ?>
                            <img src="<?= $firstPaintings[$i]->service->getThumbnail() ?>" alt="Collection Cover">
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="collection-card__info">
        <?php if ($model->is_private): ?>
            <div class="collection-card__lock">
                <?= Html::icon('lock') ?>
            </div>
        <?php endif; ?>
        <p class="collection-card__title">
            <?= $model->title ?>
        </p>
    </div>
    <?php if ($isOwner): ?>
        <div class="collection-card__edit">
            <?= Html::icon('pencil'); ?>
        </div>
    <?php endif; ?>
</a>
