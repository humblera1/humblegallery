<?php

use common\modules\user\models\search\UserCollectionSearch;
use common\widgets\PopupFilterWidget;
use common\widgets\SearchWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @var View $this
 * @var UserCollectionSearch $model
 * @var ActiveDataProvider $provider
 */

$sections = $provider->getTotalCount() === 0 ? [] : [
    [
        'attribute' => 'sort',
        'items' => [
            $model::SORT_BY_TITLE => 'В алфавитном порядке',
            $model::SORT_BY_LAST_SAVE => 'Последнее сохранение',
        ],
    ],
    [
        'attribute' => 'subjectIds',
        'multiple' => true,
        'items' => ArrayHelper::map($model->subjects, 'id', 'name'),
    ],
    [
        'attribute' => 'artistIds',
        'multiple' => true,
        'items' => ArrayHelper::map($model->artists, 'id', 'name'),
    ],
];

?>

<section class="profile-collections__controls">
    <div class="profile-collections__search">
        <?= SearchWidget::widget([
            'searchModel' => $model,
            'field' => 'paintingsTitle',
        ]) ?>
    </div>
    <div class="profile-collections__badges">
        <?php if ($provider->getTotalCount() > 0): ?>
            <?= PopupFilterWidget::widget([
                'searchModel' => $model,
                'sections' => $sections,
            ]) ?>
        <?php endif; ?>
    </div>
</section>
