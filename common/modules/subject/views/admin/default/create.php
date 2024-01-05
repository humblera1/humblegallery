<?php

use common\modules\subject\models\data\Subject;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Subject $model
 */


$this->title = Yii::t('app', 'Добавление жанра');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Жанры'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
