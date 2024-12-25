<?php

use common\modules\movement\models\data\Movement;
use common\modules\painting\models\search\PaintingSearch;
use common\widgets\FilterWidget;
use frontend\assets\painting\PaintingAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var $model PaintingSearch
 * @var ActiveDataProvider $dataProvider
 */

PaintingAsset::register($this);

$this->registerCss(<<<CSS

.painting-container {
    display: grid;
    grid-template-columns: 1fr 3fr;
}

CSS);

?>
<div class="painting-container">
    <?= FilterWidget::widget([
        'searchModel' => $model,
        'models' => [
            Movement::class,
        ],
    ]) ?>
<!--    --><?php //= $this->render('includes/_sidebar', ['model' => $model]) ?>

    <?php Pjax::begin() ?>
    <div class="painting-catalog">
        <main class="content">
            <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
        </main>
    </div>
    <?php Pjax::end() ?>
</div>

<?php if (!Yii::$app->user->isGuest): ?>
    <?= $this->render('includes/_modal') ?>
<?php endif; ?>

<div id="cache" hidden></div>

