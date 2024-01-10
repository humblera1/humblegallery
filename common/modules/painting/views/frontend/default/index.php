<?php

use common\modules\painting\models\data\Painting;
use frontend\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
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

$js = <<<JS
    var content = document.querySelector('.content');
    var msnry = new Masonry(content, {
      columnWidth: '.paint-container',
      itemSelector: '.paint-container',
      percentPosition: true
    });
JS;

$this->registerJs($js);

//MasonryAsset::register($this);
?>
<script src="/js/masonry.js"></script>
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
                ]); ?>

                <label for="test">Пейзаж</label>
                <input id='test' type="checkbox" name="PaintingSearch[subject]" value="Пейзаж">

                <?php ActiveForm::end(); ?>
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
                    <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
                </div>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<?php

$this->registerJs(<<<JS

    let form = $('#filters');

    $('#test').on('change', function () {
        makeRequest();
    })

    // let paintingCatalog = $('.painting-catalog');
    //
    const makeRequest = () => $.post('apply-filters', $(form).serializeArray());
    
    //
    // function applyFilter() {
    //     makeRequest()
    //         .done(function (data) {
    //             paintingCatalog.innerHTML = data;
    //         })
    // }

JS);


?>

