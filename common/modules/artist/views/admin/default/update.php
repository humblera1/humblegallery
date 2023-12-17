<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\artist\models\data\Artist $model */

$this->title = 'Update Artist: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Artists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
