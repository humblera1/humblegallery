<?php

use common\modules\technique\models\data\Technique;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Technique $model
 * @var ActiveForm $form
 */

?>

<div class="technique-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
