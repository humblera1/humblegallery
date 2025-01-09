<?php

use common\helpers\Html;
use common\modules\collection\models\data\Collection;
use yii\web\View;

/**
 * @var View $this
 * @var Collection $collection
 */

?>

<div class="collection-preview" data-collection-id="<?= $collection->id ?>">
    <div class="collection-preview__content">
        <div class="collection-preview__preview">
            <img src="<?= $collection->service->getPreviewImage() ?>" alt="Collection Preview">
        </div>
        <p class="collection-preview__title">
            <?= $collection->title ?>
        </p>
    </div>
    <div class="collection-preview__icons">
        <?php if ($collection->contains_painting): ?>
            <div class="collection-preview__check" title="Картина сохранена в коллекции">
                <?= Html::icon('check') ?>
            </div>
        <?php endif; ?>
        <?php if ($collection->is_private): ?>
            <div class="collection-preview__lock" title="Закрытая коллекция">
                <?= Html::icon('lock') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
