<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\movement\models\data\Movement $model */

$this->title = Yii::t('app', 'Добавить направление');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Направления'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
