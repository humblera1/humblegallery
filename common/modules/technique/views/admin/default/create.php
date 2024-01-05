<?php

use common\modules\technique\models\data\Technique;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Technique $model
 */

$this->title = Yii::t('app', 'Добавление техники');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Техники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="technique-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
