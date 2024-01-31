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
    <div class="collection-item__title"> <?= Html::encode($collection->title) ?> </div>
    <div class="collection-item__preview">

    </div>
</div>

