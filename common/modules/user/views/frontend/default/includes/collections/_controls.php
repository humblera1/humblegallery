<?php

use common\modules\user\models\search\UserCollectionSearch;
use common\widgets\PopupFilterWidget;
use common\widgets\SearchWidget;
use yii\web\View;

/**
 * @var View $this
 * @var UserCollectionSearch $model
 * @var bool $isOwner
 */

$sections = [
    [
        'attribute' => 'sort',
        'items' => [
            $model::SORT_BY_TITLE => 'В алфавитном порядке',
            $model::SORT_BY_LAST_SAVE => 'Последнее сохранение',
        ],
    ]
];

if ($isOwner) {
    $sections = array_merge($sections, [
        [
            'attribute' => 'is_private',
            'selected' => '',
            'items' => [
                '' => 'Все',
                '0' => 'Только публичные',
                '1' => 'Только закрытые',
            ],
        ],
        [
            'attribute' => 'is_archived',
            'selected' => '',
            'items' => [
                '' => 'Все',
                '0' => 'Только активные',
                '1' => 'Только архивированные',
            ],
        ]
    ]);
}

?>

<section class="profile-collections__controls">
    <div class="profile-collections__search">
        <?= SearchWidget::widget([
            'searchModel' => $model,
            'field' => 'title',
        ]) ?>
    </div>
    <div class="profile-collections__filters">
        <?= PopupFilterWidget::widget([
            'searchModel' => $model,
            'sections' => $sections,
        ]) ?>
    </div>
</section>
