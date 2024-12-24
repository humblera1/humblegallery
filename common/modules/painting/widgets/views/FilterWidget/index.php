<?php
use common\modules\movement\models\data\Movement;
use common\modules\technique\models\data\Technique;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model ActiveRecord
 */


?>

<aside id="filter-widget">
    <div class="filters">
        <div class="filters__header">
            <p> Фильтры </p>
        </div>
        <div class="filters__body">
            <?php $form = ActiveForm::begin([
                'id' => 'painting-form',
                'action' => "filtering",
            ]);
            ?>
            <?= $this->render('includes/_section', ['model' => $model]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<!--    <div class="filter__body">-->
<!--        --><?php //$form = ActiveForm::begin([
//            'id' => 'painting-form',
//            'action' => "filtering",
//        ]);
//        ?>
<!--            --><?php //= Html::activeCheckboxList(
//                $model,
//                'movements',
//                ArrayHelper::map(Movement::find()->all(), 'id', 'name'),
//                [
//                    'tag' => 'div class="painting-filter__block--item"',
//                    'itemOptions' => [
//                        'class' => 'filter',
//                    ],
//                ]
//            ); ?>
<!--            --><?php //= Html::activeCheckboxList(
//                $model,
//                'techniques',
//                ArrayHelper::map(Technique::find()->all(), 'id', 'name'),
//                [
//                    'tag' => 'div class="painting-filter__block--item"',
//                    'itemOptions' => [
//                        'class' => 'filter',
//                    ],
//                ]
//            ); ?>
<!--        --><?php //ActiveForm::end(); ?>
<!--    </div>-->
</aside>
