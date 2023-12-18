<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\artist\models\data\Artist $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="artist-form">
    <div class="col-md-12 mt-5 row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'born')->widget(DatePicker::class, [
                'options' => [
                    'id' => 'born',
                    'placeholder' => 'Выберите дату рождения',
                    'value' => Yii::$app->formatter->asDate($model->born, 'php:d.m.Y'),
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'minViewMode'=>'years',
                    'format' => 'yyyy',
                    'orientation' => 'bottom',
                ],
            ]) ?>

            <?= $form->field($model, 'died')->widget(DatePicker::class, [
                'options' => [
                    'id' => 'died',
                    'placeholder' => 'Выберите дату рождения',
                    'value' => Yii::$app->formatter->asDate($model->died, 'php:d.m.Y'),
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'minViewMode'=>'years',
                    'format' => 'yyyy',
                    'orientation' => 'bottom',
                ],
            ]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
            </div>
        </div>
        <div class="col-md-6 px-5">
            <?= $form->field($model, 'image_path')->fileInput() ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
