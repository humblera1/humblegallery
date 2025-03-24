<?php

use common\modules\artist\models\data\Artist;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Artist $model
 * @var ActiveForm $form
 */

$this->registerCss(<<<CSS
    .humble-form-group {
        margin-bottom: 1.6rem;
    }

    .image-container--form {
        max-width: 800px
    }
CSS
);

$this->registerJs(<<<JS
    $('#image-input').on('change', function () {
        const file = this.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result)
            };
            
            reader.readAsDataURL(file)
        }        
    });
JS);

$imageSrc = $model->isNewRecord ? '' : $model->service->getImage();

?>

<div class="artist-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'col-md-12 row']]); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="datepicker-container">
            <?= $form->field($model, 'born')->widget(DatePicker::class, [
                'pluginOptions' => [
                    'autoclose' => true,
                    'minViewMode'=>'years',
                    'format' => 'yyyy',
                    'startView' => 3,
                    'orientation' => 'bottom',
                ],
            ]) ?>

            <?= $form->field($model, 'died')->widget(DatePicker::class, [
                'pluginOptions' => [
                    'autoclose' => true,
                    'minViewMode'=>'years',
                    'format' => 'yyyy',
                    'startView' => 3,
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
        <div class="image-container--form">
            <?= Html::img($imageSrc, ['class' => 'image--form img-fluid', 'id' => 'image-preview']); ?>
        </div>
        <?= $form->field($model, 'image')->fileInput(['id' => 'image-input']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
