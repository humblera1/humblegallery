<?php

use backend\components\widgets\HumbleGridView;
use common\modules\artist\models\data\Artist;
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

            'id',
            'name',
            'born',
            'died',
            'description',
            //'image_path',
            //'rating',
            //'created_at',
            //'updated_at',
            //'is_deleted',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Artist $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
