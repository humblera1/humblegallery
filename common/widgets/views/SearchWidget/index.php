<?php

use common\helpers\Html;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

/**
 * @var $searchModel ActiveRecord
 * @var $field string
 */

$inputName = "{$searchModel->formName()}[$field]";

?>

<div id="search-widget">
    <?php $form = ActiveForm::begin([
        'id' => 'search-widget-form',
        'options' => [
            'data-pjax' => true,
        ],
    ]);
    ?>
        <div class="search__container">

            <button type="submit" class="search__badge">
                <?= Html::icon('loup'); ?>
            </button>
            <input name="<?= $inputName ?>" type="text" class="search__input" placeholder="Поиск..." />
        </div>
    <?php ActiveForm::end(); ?>
</div>
