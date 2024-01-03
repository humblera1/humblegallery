<?php

use common\modules\artist\models\data\Artist;
use common\modules\painting\models\data\Painting;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Painting $model
 * @var ActiveForm $form
 */
?>

<div class="painting-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'col-md-12 row']]); ?>

    <div class="col-md-6 mt-5">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <div class="datepicker-container">
            <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
                'options' => [
                    'value' => $model->start_date ? Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') : null,
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                    'orientation' => 'bottom',
                ],
            ]) ?>

            <?= $form->field($model, 'end_date')->widget(DatePicker::class, [
                'options' => [
                    'value' => $model->end_date ? Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') : null,
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                    'orientation' => 'bottom',
                ],
            ]) ?>
        </div>

        <div class="kartik-select2-container">
            <?= $form->field($model, 'artist_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Artist::find()->all(), 'id', 'name'),
                'pluginOptions' => [
                    'positionDropdown' => true,
                ],
            ]) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Сохранить'), ['class' => 'btn btn-orange']) ?>
        </div>
    </div>

    <div class="col-md-4 mt-5">
        <?= $form->field($model, 'image')->fileInput() ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
