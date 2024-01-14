<?php

use backend\components\widgets\HumbleActiveField;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\artist\models\data\Artist $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss(<<<CSS
    
    .humble-form-group {
        margin-bottom: 1.6rem;
    }
CSS
);

?>

<div class="artist-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'col-md-12 row']]); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="datepicker-container">
            <?= $form->field($model, 'born')->widget(DatePicker::class, [
                'options' => [
                    'id' => 'born',
                    'value' => $model->born ? Yii::$app->formatter->asDate($model->born, 'php:d.m.Y') : null,
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
                    'value' => $model->died ? Yii::$app->formatter->asDate($model->died, 'php:d.m.Y') : null,
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'minViewMode'=>'years',
                    'format' => 'yyyy',
                    'orientation' => 'bottom',
                ],
            ]) ?>
        </div>

        <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-orange']) ?>
        </div>
    </div>
    <div class="col-md-6 d-flex align-items-center flex-column">
        <?php if (!$model->isNewRecord): ?>
            <div class="image-container--form">
                <?= Html::img($model->service->getImage(), ['class' => 'image--form']); ?>
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'image')->fileInput() ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
