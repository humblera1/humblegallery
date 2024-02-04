<?php

use common\modules\collection\models\data\Collection;
use yii\web\View;

/**
 * @var View $this
 * @var Collection[] $collections
 */

?>

<div class="collection-choice_existing">
    <div class="collection-box">
        <div class="collection-item">
            <div id="new-collection" class="collection-item__preview collection-item__preview--blank">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div class="collection-item__title"> <span>Новая коллекция</span> </div>
        </div>
        <?php foreach ($collections as $collection): ?>
            <?= $this->render('_collection', ['collection' => $collection]); ?>
        <?php endforeach; ?>
    </div>
</div>
