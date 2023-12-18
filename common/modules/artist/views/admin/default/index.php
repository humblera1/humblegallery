<?php

use backend\components\widgets\HumbleGridView;
use common\modules\artist\models\data\Artist;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\modules\artist\models\search\ArtistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Художники';
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML

HTML;

?>
<div class="artist-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a('Create Artist', ['create'], ['class' => 'btn btn-orange']) ?>
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
                'filter' => DatePicker::widget([
                    'attribute' => 'born',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'minViewMode'=>'years',
                        'format' => 'yyyy',
                    ],
                    'options' => [
                        'placeholder' => 'Дата рождения',
                    ]
                ]),
            ],
            [
                'attribute' => 'died',

                'filter' => DatePicker::widget([
                    'attribute' => 'died',

                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'minViewMode'=>'years',
                        'format' => 'yyyy',
                    ],
                    'options' => [
                        'placeholder' => 'Дата смерти',
                    ]
                ]),
            ],
            //'updated_at',
            //'is_deleted',
            [
                'class' => ActionColumn::class,
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
