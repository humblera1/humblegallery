<?php

use common\helpers\Html;
use common\modules\collection\models\data\Collection;
use common\modules\user\models\data\User;
use common\widgets\MasonryWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var $this View
 * @var $model Collection
 * @var $provider ActiveDataProvider
 * @var $user User
 */

$isOwner = Yii::$app->user->identity?->id === $user->id;

// todo: вернуть после тестов
$isOwner = true;

?>

<div class="profile-collection">
    <header class="profile-collection__header">
        <h1 class="title"><?= $model->title ?></h1>
        <div class="profile-collection__statistics">
            <div class="profile-collection__statistic">
                <div class="profile-collection__badge">
                    <?= Html::icon('art'); ?>
                </div>
                <div class="profile-collection__info">
                    <p class="profile-collection__label"><?= $provider->count ?></p>
                    <p class="profile-collection__text">картины</p>
                </div>
            </div>
            <div class="profile-collection__statistic">
                <div class="profile-collection__badge">
                    <?= Html::icon('brush'); ?>
                </div>
                <div class="profile-collection__info">
                    <p class="profile-collection__label"><?= count($model->subjects) ?></p>
                    <p class="profile-collection__text">жанры</p>
                </div>
            </div>
            <div class="profile-collection__statistic">
                <div class="profile-collection__badge">
                    <?= Html::icon('user'); ?>
                </div>
                <div class="profile-collection__info">
                    <p class="profile-collection__label"><?= count($model->artists) ?></p>
                    <p class="profile-collection__text">авторы</p>
                </div>
            </div>
        </div>
    </header>
    <div class="profile-collection__body">

        <?= $this->render('includes/collection/_controls', compact('isOwner', 'model')); ?>

        <main class="profile-collection__content">
            <?= MasonryWidget::widget(['provider' => $provider]) ?>
        </main>
    </div>
</div>
