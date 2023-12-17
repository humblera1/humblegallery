<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \common\modules\painting\data\User $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <div class="d-flex justify-content-between align-items-center py-4 px-5">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-orange mx-3']) ?>
            <?= Html::a('Заблокировать', ['delete', 'id' => $model->id], [
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
                'username',
                'email:email',
                'password_hash',
                'name',
                'surname',
                'is_verified',
                'is_blocked',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>
