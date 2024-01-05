<?php

use common\modules\painting\models\data\Painting;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Painting $model
 */

$this->title = Yii::t('app', 'Добавить картину');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Картины'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="painting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
