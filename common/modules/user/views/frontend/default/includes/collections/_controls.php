<?php

use common\helpers\Html;
use common\modules\user\models\search\UserCollectionSearch;
use common\widgets\PopupFilterWidget;
use common\widgets\SearchWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var UserCollectionSearch $model
 * @var ActiveDataProvider $provider
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
            'selected' => 0,
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
    <div class="profile-collections__badges">
        <?php if ($isOwner): ?>
            <div id="new-collection" class="profile-collections__new" title="Новая коллекция">
                <?= Html::icon('plus') ?>
            </div>
        <?php endif; ?>

        <?php if ($isOwner || $provider->getTotalCount() > 0): ?>
            <?= PopupFilterWidget::widget([
                'searchModel' => $model,
                'sections' => $sections,
            ]) ?>
        <?php endif; ?>
    </div>
</section>
