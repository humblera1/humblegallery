<?php

use common\modules\collection\models\data\Collection;
use common\modules\user\models\search\UserCollectionSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 * @var UserCollectionSearch $searchModel
 * @var Collection $model
 */

?>

<div id="section" class="section section_collections" data-section-name="collections">
    <?php Pjax::begin(['id' => 'collection-pjax']) ?>
    <div class="section__header">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'new-collection', 'data-pjax' => true]]); ?>
        <div class="section-search">
            <?= $form->field($model, 'title'); ?>
        </div>
        <?= Html::submitButton('Создать', ['class' => 'btn btn-orange']) ?>
        <?php ActiveForm::end() ?>
    </div>

    <div class="section__header">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'collections-search', 'data-pjax' => true]]); ?>
        <div class="section-search">
            <?= $form->field($searchModel, 'title'); ?>
        </div>
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-orange']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="section__content">

        <div class="collection-choice_existing">
            <div class="collection-box">
                <?= ListView::widget([
                    'dataProvider' => $provider,
                    'itemView' => '@common/views/_collection',
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end() ?>
</div>
