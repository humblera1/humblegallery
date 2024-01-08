<?php

use common\modules\painting\models\data\Painting;
use frontend\assets\MasonryAsset;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var Painting[] $models
 * @var Pagination $pages
 */

//MasonryAsset::register($this);

$js = <<<JS
    var content = document.querySelector('.content');
    var msnry = new Masonry(content, {
      columnWidth: '.paint-container',
      itemSelector: '.paint-container',
      percentPosition: true
    });
JS;


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
                <!-- Sidebar content goes here -->
            </aside>

            <?php Pjax::begin() ?>
            <main class="content">
                <?php foreach($models as $model): ?>
                    <div class="paint-container">
                        <div class="paint-content">

                            <div class="paint-content__image-wrapper">
                                <?= Html::img($model->service->getThumbnail(), ['class' => 'paint-content__image']); ?>
                            </div>

                            <div class="paint-content__title">
                                <?= $model->title ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </main>
            <?= LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<?php
//Закинуть в Pjax
$this->registerJs($js);
?>

