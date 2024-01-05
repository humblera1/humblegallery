<?php

use common\modules\user\models\data\User;
use yii\helpers\Html;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var User $model
 */

$this->title = $model->service->getName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
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
                'username',
                'email:email',
                'name',
                'surname',
                'is_verified:boolean',
                'is_blocked',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d.m.Y'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:d.m.Y'],
                ],
            ],
        ]) ?>
    </div>
</div>
