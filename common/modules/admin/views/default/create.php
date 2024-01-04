<?php

use common\modules\admin\models\form\AdminForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AdminForm $model
 */

$this->title = Yii::t('app', 'Добавление администратора');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Администраторы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
