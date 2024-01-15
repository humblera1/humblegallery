<?php

use common\modules\painting\models\search\PaintingSearch;
use frontend\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var $model PaintingSearch
 * @var ActiveDataProvider $dataProvider
 */

MasonryAsset::register($this);

?>

<?= $this->render('includes/_sidebar', ['model' => $model]) ?>

<?php Pjax::begin() ?>
<div class="painting-catalog">
    <main class="content">
        <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
    </main>
</div>
<?php Pjax::end() ?>

