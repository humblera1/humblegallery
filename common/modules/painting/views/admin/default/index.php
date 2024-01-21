<?php

use backend\components\widgets\HumbleGridView;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;
use kartik\date\DatePicker;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var PaintingSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Картины';
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->session->getFlash('error');

?>
<div class="painting-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('app','Добавить картину'), ['create'], ['class' => 'btn btn-orange']) ?>
        </p>
    </div>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= HumbleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function(Painting $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => 'artist',
                'format' => 'raw',
                'value' => function(Painting $model) {
                    return Html::a($model->artist->name, ['/artist/default/view', 'id' => $model->artist->id]);
                }
            ],
            [
                'attribute' => 'start_date',
                'filter' => DatePicker::widget([
                    'attribute' => 'start_date',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'minViewMode'=>'years',
                        'format' => 'yyyy',
                        'startView' => 3,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата начала',
                    ]
                ]),
            ],
            [
                'attribute' => 'end_date',
                'filter' => DatePicker::widget([
                    'attribute' => 'end_date',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'minViewMode'=>'years',
                        'format' => 'yyyy',
                        'startView' => 3,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата завершения',
                    ]
                ]),
            ],
            [
                'attribute' => 'rating',
                'label' => 'Рейтинг',
            ],
            'rating',
            //'is_deleted',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Painting $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
