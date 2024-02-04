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
        <?php foreach ($collections as $collection): ?>
            <?php $this->render('_collection', ['collection' => $collection]); ?>
        <?php endforeach; ?>
    </div>
</div>
