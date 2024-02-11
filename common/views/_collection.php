<?php

use common\modules\collection\models\data\Collection;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Collection $model
 */

$collectionTitle = Html::encode($model->title);

?>

<div class="collection-item" data-collection-id="<?= $model->id ?>" data-collection-title="<?= $collectionTitle ?>">
    <div class="collection-item__preview">
        <div class="collection-item__mark">
            <i class="fa-solid fa-check"></i>
        </div>
        <?php if ($previewImage = $model->service->getPreviewImage()): ?>
            <img src="<?= $previewImage ?>" alt="Обложка коллекции">
        <?php else: ?>
            <img src="" alt="Обложка коллекции">
        <?php endif; ?>
    </div>
    <div class="collection-item__title"> <?= $collectionTitle ?> </div>
</div>
