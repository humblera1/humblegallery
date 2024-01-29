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
    <div class="d-flex row py-4 col-txl-8 col-lg-12">
        <h2 class="col-lg-6 col-md-12 mb-4"><?= Html::encode($model->service->getNameToDisplay()) ?></h2>
        <p class="col-lg-6 col-md-12 d-flex justify-content-lg-end align-items-center">
            <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-orange']) ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger mx-3',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <div class="row gx-4">
        <div class="col-txl-4 col-xl-6 col-lg-10">
            <?= Html::img($model->service->getImage(), ['class' => 'img-fluid rounded-5 shadow']); ?>
        </div>
        <div class="col-txl-4 col-xl-6 col-lg-10">

            <div class="py-3">
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold">Художник:</div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= $model->artist->name; ?></div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold">Техника:</div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= $model->technique->name; ?></div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold"><?= Yii::t('app', 'Направления:') ?></div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= $model->service->getMovementsList(); ?></div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold"><?= Yii::t('app', 'Жанры:') ?></div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= $model->service->getSubjectsList(); ?></div>
                    </div>
                </div>
            </div>
            <div class="py-3">
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold">Дата добавления:</div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= Yii::$app->formatter->asDatetime($model->created_at); ?></div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold">Дата создания:</div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= Yii::$app->formatter->asDatetime($model->updated_at); ?></div>
                    </div>
                </div>
            </div>
            <div class="py-3">
                <div class="row col-12">
                    <div class="col-4">
                        <div class="fs-5 fw-bold">В архиве:</div>
                    </div>
                    <div class="col-8">
                        <div class="fs-5"><?= $model->is_deleted ? 'Да' : 'Нет'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>