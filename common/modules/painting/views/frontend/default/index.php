<?php

use common\modules\painting\models\data\Painting;
use common\modules\subject\models\data\Subject;
use frontend\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var Painting[] $models
 * @var Pagination $pages
 */



MasonryAsset::register($this);
?>
<!--<script src="/js/masonry.js"></script>-->
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
                <!-- Sidebar content goes here -->
            </aside>
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => Painting::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);            ?>

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

