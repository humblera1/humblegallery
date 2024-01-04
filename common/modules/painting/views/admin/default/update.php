<?php

use common\modules\painting\models\data\Painting;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Painting $model
 */

$this->title = 'Update Painting: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Paintings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="painting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
