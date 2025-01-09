<?php

use common\helpers\Html;
use common\modules\collection\models\data\Collection;
use yii\web\View;

/**
 * @var View $this
 * @var Collection[] $collections
 * @var int $paintingId
 */

?>

<div class="modal-collections__list">
    <div class="collection-preview" data-type="action">
        <div class="collection-preview__content">
            <div class="collection-preview__preview collection-preview__preview_new">
                <?= Html::icon('plus'); ?>
            </div>
            <p class="collection-preview__title">
                Создать коллекцию
            </p>
        </div>
    </div>

    <?php foreach ($collections as $collection): ?>
        <?= $this->render('@common/views/_collection-preview', [
            'collection' => $collection,
        ]); ?>
    <?php endforeach; ?>
</div>
