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
                    'id' => 'filters',
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
<!--                    <main class="content">-->
                    <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
<!--                    </main>-->
                </div>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<?php

$this->registerJs(<<<JS

    const content = document.querySelector('.content');

    let form = $('#filters');
    let paintingCatalog = document.querySelector('.painting-catalog');
    // console.log(content);
    
    $('.filter').each((index, filter) => {
        filter.addEventListener('change', applyFilters);
    })
    
    $(document).ready(function() {
        initMasonry();
    })
    
    initMasonry();
    const makeRequest = () => $.post('apply-filters', $(form).serializeArray());
    
    function applyFilters () {
        makeRequest()
        .done(function (data) {
            reloadContent(data);
            reloadMasonry();
        });
    }
    
    function reloadContent (data) {
        $('.content').html(data);
        // paintingCatalog.innerHTML = data;
    }
    
    function reloadMasonry () {
        initMasonry();
        $('.content').masonry();
        // $('.content').masonry('reloadItems');
    }
    
    function initMasonry () {
        $('.content').masonry({
            columnWidth: '.paint-container',
            itemSelector: '.paint-container',
            percentPosition: true
        })
    }
JS);

?>

