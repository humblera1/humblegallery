<?php

use common\components\widgets\LinkPager;
use common\modules\user\models\data\User;
use common\modules\user\models\search\UserCollectionSearch;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var User $user
 * @var UserCollectionSearch $model
 * @var ActiveDataProvider $provider
 */

$isOwner = Yii::$app->user->identity?->id === $user->id;

?>

<div class="profile-collections">
    <header class="profile-collections__header">
        <h1 class="profile-collections__title">Коллекции</h1>
    </header>
    <div class="profile-collections__body">
        <?= $this->render('includes/collections/_controls', compact('isOwner', 'model', 'provider')); ?>

        <div class="profile-collections__content">
            <?php Pjax::begin(['id' => 'collections-pjax-container', 'enablePushState' => false]) ?>

            <?= ListView::widget([
                'dataProvider' => $provider,
                'layout' => "{items}\n{pager}",
                'itemView' => '@common/views/_collection-card',
                'viewParams' => ['isOwner' => $isOwner],
                'options' => [
                    'class' => 'profile-collections__list',
                ],
                'pager' => [
                    'class' => LinkPager::class,
                ],
            ]); ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<?php if ($isOwner): ?>
    <?= $this->render('includes/collections/_modal'); ?>
<?php endif; ?>
