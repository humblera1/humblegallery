<?php

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use common\modules\user\models\search\FavoritePaintingSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 * @var FavoritePaintingSearch $model
 */

?>

<div id="section" class="section section_favorites" data-section-name="favorites">
    <?php Pjax::begin(['id' => 'favorite-pjax']) ?>
    <div class="section__header">
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
        <div class="section-search">
            <?= $form->field($model, 'title'); ?>
        </div>
        <div class="section-filters">
            <?= $form->field($model, 'artists')->dropDownList(ArrayHelper::map(Artist::find()->all(), 'id', 'name'), ['prompt' => 'Все']); ?>
        </div>
        <div class="section-filters">
            <?= $form->field($model, 'subjects')->dropDownList(ArrayHelper::map(Subject::find()->all(), 'id', 'name'), ['prompt' => 'Все', 'multiple' => true]); ?>
        </div>
        <div class="section-filters">
            <?= $form->field($model, 'techniques')->dropDownList(ArrayHelper::map(Technique::find()->all(), 'id', 'name'), ['prompt' => 'Все', 'multiple' => true]); ?>
        </div>
        <div class="section-filters">
            <?= $form->field($model, 'movements')->dropDownList(ArrayHelper::map(Movement::find()->all(), 'id', 'name'), ['prompt' => 'Все', 'multiple' => true]); ?>
        </div>
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-orange']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="section__content">

        <div class="painting-catalog">
            <main class="content">
                <?= ListView::widget([
                    'dataProvider' => $provider,
                    'itemView' => '@common/views/_painting',
                ]); ?>
            </main>
        </div>
    </div>
    <?php Pjax::end() ?>
</div>
