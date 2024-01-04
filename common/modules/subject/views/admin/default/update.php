<?php

use common\modules\subject\models\data\Subject;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Subject $model
 */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Жанры'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
