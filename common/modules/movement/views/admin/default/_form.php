<?php

use common\modules\movement\models\data\Movement;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Movement $model
 * @var ActiveForm $form
 */

?>

<div class="movement-form">
    <div class="col-md-12 mt-5 row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-orange']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
