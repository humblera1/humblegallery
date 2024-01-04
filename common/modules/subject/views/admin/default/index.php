<?php

use backend\components\widgets\HumbleGridView;
use common\modules\subject\models\search\SubjectSearch;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var SubjectSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Жанры');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('app', 'Добавить жанр'), ['create'], ['class' => 'btn btn-orange']) ?>
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
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
