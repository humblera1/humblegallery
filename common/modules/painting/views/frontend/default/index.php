<?php

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\search\PaintingSearch;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use common\widgets\FilterWidget;
use common\widgets\MasonryWidget;
use common\widgets\SearchWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var $this View
 * @var $model PaintingSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Галерея';

?>
<div class="paintings">
    <?= FilterWidget::widget([
        'searchModel' => $model,
        'filters' => [
            'Направления' => Movement::class,
            'Техники' => Technique::class,
            'Жанры' => Subject::class,
            'Художники' => Artist::class,
        ],
    ]) ?>
    <div class="paintings__content">
        <header class="paintings__header">
            <h1 class="title">Галерея</h1>
            <?= SearchWidget::widget([
                'searchModel' => $model,
                'field' => 'title',
            ]) ?>
        </header>
        <?= MasonryWidget::widget(['provider' => $dataProvider]); ?>
    </div>
</div>
