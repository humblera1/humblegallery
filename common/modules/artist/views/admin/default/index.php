<?php

use backend\components\widgets\HumbleGridView;
use common\modules\artist\models\search\ArtistSearch;
use kartik\date\DatePicker;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ArtistSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Художники');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="artist-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('app', 'Добавить художника'), ['create'], ['class' => 'btn btn-orange']) ?>
        </p>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= HumbleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'born',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => DatePicker::widget([
                    'attribute' => 'born',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'minViewMode'=>'years',
                        'format' => 'yyyy',
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата рождения',
                    ]
                ]),
            ],
            [
                'attribute' => 'died',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => DatePicker::widget([
                    'attribute' => 'died',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'minViewMode'=>'years',
                        'format' => 'yyyy',
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата смерти',
                    ]
                ]),
            ],
//            'is_deleted:boolean',
            [
                'class' => ActionColumn::class,
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
