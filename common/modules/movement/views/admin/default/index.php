<?php

use backend\components\widgets\HumbleGridView;
use common\modules\movement\models\data\Movement;
use common\modules\movement\models\search\MovementSearch;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var MovementSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Направления');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movement-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('app', 'Добавить направление'), ['create'], ['class' => 'btn btn-orange']) ?>
        </p>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= HumbleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Movement $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
