<?php

use common\modules\admin\models\form\AdminForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var AdminForm $model */
/** @var yii\widgets\ActiveForm $form */

$test = $model->getRoleList();

?>

<div class="admin-form">

    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?php $label = $model->isNewRecord ? 'Пароль' : 'Новый пароль' ?>
        <?= $form->field($model, 'password')->passwordInput()->label($label) ?>

        <div class="kartik-select2-container">
        <?= $form->field($model, 'role')->widget(Select2::class, [
            'data' => ArrayHelper::map($model->getRoleList(), 'name', 'description'),
        ]) ?>
        </div>

        <?= $form->field($model, 'status')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-orange']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
