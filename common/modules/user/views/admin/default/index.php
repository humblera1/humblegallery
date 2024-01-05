<?php

use backend\components\widgets\HumbleGridView;
use common\modules\user\models\data\User;
use common\modules\user\models\search\UserSearch;
use kartik\date\DatePicker;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var UserSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= HumbleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            'username',
            'email:email',
            'name',
            'surname',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => DatePicker::widget([
                    'attribute' => 'created_at',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата регистрации',
                        'value' => $searchModel->created_at ?
                            Yii::$app->formatter->asDate($searchModel->created_at)
                            : '',
                    ]
                ]),
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
