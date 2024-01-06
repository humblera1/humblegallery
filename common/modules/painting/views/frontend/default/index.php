<?php

use common\modules\painting\models\data\Painting;
use yii\data\Pagination;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var Painting[] $models
 * @var Pagination $pages
 */

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
                <!-- Sidebar content goes here -->
            </aside>

            <?php Pjax::begin() ?>
            <main class="content">
                <?php foreach($models as $model): ?>
                    <div class="paint">
                        <div class="paint__paint">
                            <?= $model->title ?>
                            <!-- picture goes here -->
                        </div>
                        <div class="paint__description">
                            <!-- description goes here -->
                        </div>
                    </div>
                <?php endforeach; ?>

                <?= LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
            </main>
            <?php Pjax::end() ?>
        </div>



        <!--    <footer class="footer">-->
        <!--        Footer content goes here -->
        <!--    </footer>-->
    </div>
</div>

