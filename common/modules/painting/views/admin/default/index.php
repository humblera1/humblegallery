<?php

use backend\components\widgets\HumbleGridView;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;
use kartik\date\DatePicker;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var PaintingSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Картины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="painting-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('app','Добавить картину'), ['create'], ['class' => 'btn btn-orange']) ?>
        </p>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= HumbleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                'attribute' => 'artist_id',
            ],
            [
                'attribute' => 'start_date',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => DatePicker::widget([
                    'attribute' => 'start_date',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата начала',
                        'value' => $searchModel->start_date ?
                            Yii::$app->formatter->asDate($searchModel->start_date)
                            : '',
                    ]
                ]),
            ],
            [
                'attribute' => 'end_date',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => DatePicker::widget([
                    'attribute' => 'end_date',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата завершения',
                        'value' => $searchModel->end_date ?
                            Yii::$app->formatter->asDate($searchModel->end_date)
                            : '',
                    ]
                ]),
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
