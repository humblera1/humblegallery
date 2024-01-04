<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\modules\movement\models\data\Movement $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Movements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="movement-view">
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
                'name',
            ],
        ]) ?>
    </div>
</div>
