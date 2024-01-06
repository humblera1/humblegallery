<?php

use common\modules\painting\models\data\Painting;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Painting $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Картины'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="painting-view">

    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-orange mx-3']) ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

    <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-bordered table-hover detail-view'],
            'template' => '<tr><td><strong>{captionOptions}{label}:</strong></td><td>{contentOptions}{value}</td></tr>',
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'artist_id',
                    'value' => $model->artist->name,
                ],
                [
                    'attribute' => 'start_date',
                    'value' => $model->start_date ? Yii::$app->formatter->asDate($model->start_date) : null,
                ],
                [
                    'attribute' => 'end_date',
                    'value' => Yii::$app->formatter->asDate($model->end_date),
                ],
                [
                    'attribute' => 'movements',
                    'label' => Yii::t('app', 'Направления'),
                    'format' => 'raw',
                    'value' => $model->service->getMovementsList(),
                ],
                [
                    'attribute' => 'subjects',
                    'label' => Yii::t('app', 'Жанры'),
                    'format' => 'raw',
                    'value' => $model->service->getSubjectsList(),
                ],
                [
                    'attribute' => 'technique_id',
                    'value' => $model->technique->name,
                ],
                'rating',
                [
                    'attribute' => 'created_at',
                    'value' => Yii::$app->formatter->asDatetime($model->created_at),
                ],
                [
                    'attribute' => 'updated_at',
                    'value' => Yii::$app->formatter->asDatetime($model->updated_at),
                ],
                'is_deleted:boolean',
            ],
        ]) ?>
    </div>
    <?= Html::img($model->service->getImage()); ?>
</div>
