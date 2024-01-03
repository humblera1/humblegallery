<?php

use common\modules\artist\models\data\Artist;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Artist $model
 */

$this->title = Yii::t('app', 'Добавить художника');
$this->params['breadcrumbs'][] = ['label' => 'Artists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
