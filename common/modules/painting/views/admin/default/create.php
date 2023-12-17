<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\painting\models\data\Painting $model */

$this->title = 'Create Painting';
$this->params['breadcrumbs'][] = ['label' => 'Paintings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="painting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
