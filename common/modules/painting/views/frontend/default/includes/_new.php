<?php

use common\modules\collection\models\data\Collection;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 */

$model = new Collection();

?>

<?php $form = ActiveForm::begin([
    'id' => 'collection-form',
    'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
    'enableAjaxValidation' => true,
    'validationUrl' => '/collection/validate-form',
    'action' => '/collection/create-and-add',
]); ?>

<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'is_private')->checkbox(['label' => 'Сделать коллекцию приватной']); ?>

<div class="form-group">
    <?= Html::submitButton('Создать', ['class' => 'btn btn-orange']) ?>
</div>

<?php ActiveForm::end(); ?>



<!--<div class="collection-choice_new">-->
<!--    <div class="area">-->
<!--        <i class="fa-solid fa-plus"></i>-->
<!--    </div>-->
<!--</div>-->
