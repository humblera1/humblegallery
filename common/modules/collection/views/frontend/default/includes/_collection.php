<?php

use common\modules\collection\models\data\Collection;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Collection $collection
 */


?>

<div class="collection-item" data-collection-id="<?= $collection->id ?>">
    <div class="collection-item__preview">
        <div class="collection-item__mark">
            <i class="fa-solid fa-check"></i>
        </div>
        <?php if ($previewImage = $collection->service->getPreviewImage()): ?>
            <img src="<?= $previewImage ?>" alt="Обложка коллекции">
        <?php else: ?>
            <img src="" alt="Обложка коллекции">
        <?php endif; ?>
    </div>
    <div class="collection-item__title"> <?= Html::encode($collection->title) ?> </div>
</div>

