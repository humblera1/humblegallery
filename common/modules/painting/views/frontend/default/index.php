<?php

use common\modules\subject\models\data\Subject;
use frontend\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var ActiveDataProvider $dataProvider
 */

MasonryAsset::register($this);
?>

<div class="page">
    <div class="page__content">
        <header class="header">
            <nav class="header__navigation">
                <!-- Header navigation content goes here -->
            </nav>
        </header>

        <div class="page-container">
            <aside class="sidebar">
                <?php $form = ActiveForm::begin([
                    'id' => 'painting-form',
                    'action' => "filtering",
                ]);

                echo Html::checkboxList(
                    'PaintingSearch[subjects][]',
                    null,
                    ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
                    [
                        'class' => 'filter',
                        'separator' => '<br>',
                    ]
                );

                ActiveForm::end(); ?>
            </aside>

            <?php Pjax::begin() ?>
                <div class="painting-catalog">
                    <main class="content">
                    <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
                    </main>
                </div>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<?php

?>

