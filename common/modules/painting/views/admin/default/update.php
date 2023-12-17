<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\painting\models\data\Painting $model */

$this->title = 'Update Painting: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Paintings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="painting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
