<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\modules\painting\data\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">
    <div class="col-md-6 mt-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<!--        --><?php //= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-orange']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
