<?php

use backend\components\widgets\HumbleGridView;
use common\models\Admin;
use common\modules\admin\models\search\AdminSearch;
use kartik\date\DatePicker;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var AdminSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Администраторы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->user->identity->isSuperadmin()): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Добавить администратора'), ['create'], ['class' => 'btn btn-orange']) ?>
        </p>
        <?php endif; ?>
    </div>

    <?php Pjax::begin(); ?>

    <?php $template = Yii::$app->user->identity->isSuperadmin() ? '{view} {update} {delete}' : '{view}'; ?>

    <?= HumbleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'email:email',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y h:i:s'],
                'filter' => DatePicker::widget([
                    'attribute' => 'created_at',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Дата создания',
                        'value' => $searchModel->created_at ?
                            Yii::$app->formatter->asDate($searchModel->created_at)
                            : '',
                    ]
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d.m.Y h:i:s'],
                'filter' => DatePicker::widget([
                    'attribute' => 'updated_at',
                    'layout' => '{picker}{input}{remove}',
                    'model' => $searchModel,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'orientation' => 'bottom',
                    ],
                    'options' => [
                        'placeholder' => 'Последнее обновление',
                        'value' => $searchModel->updated_at ?
                            Yii::$app->formatter->asDate($searchModel->updated_at)
                            : '',
                    ]
                ]),
            ],
            [
                'class' => ActionColumn::class,
                'template' => $template,
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
