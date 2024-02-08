<?php

use frontend\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
* @var View $this
* @var ActiveDataProvider $provider
*/

MasonryAsset::register($this);
?>


<div class="section">
    <div class="section__header">
        <div class="section-search">
            <input type="text">
        </div>
    </div>
    <div class="section__content">
        <?php Pjax::begin() ?>
        <div class="painting-catalog">
            <main class="content">
                <?= ListView::widget([
                    'dataProvider' => $provider,
                    'itemView' => '@common/views/_painting',
                ]); ?>
            </main>
        </div>
        <?php Pjax::end() ?>
    </div>
</div>
