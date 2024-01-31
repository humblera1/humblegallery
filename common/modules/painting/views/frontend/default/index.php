<?php

use common\modules\painting\models\search\PaintingSearch;
use frontend\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var $model PaintingSearch
 * @var ActiveDataProvider $dataProvider
 */

MasonryAsset::register($this);

$this->registerCss(<<<CSS

.painting-container {
    display: grid;
    grid-template-columns: 1fr 3fr;
}

CSS);

?>
<div class="painting-container">
    <?= $this->render('includes/_sidebar', ['model' => $model]) ?>

    <?php Pjax::begin() ?>
    <div class="painting-catalog">
        <main class="content">
            <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
        </main>
    </div>
    <?php Pjax::end() ?>
</div>

<div id="overlay"> </div>
<div id="collection-modal" class="modal">
    <div class="modal__wrapper">
        <div class="modal__content">
            <div class="modal__header">
                <div class="modal-head">
                    <div class="modal-head--close">
                        <div class="close-button">×</div>
                    </div>
                    <div class="modal-head--title">
                        <h3>Выберите коллекцию</h3>
                    </div>
                </div>
            </div>
            <div class="modal__body">
                <div id="login-content" class="modal__body-content">

                    <div class="collection-choice">
                        <div class="collection-choice_new">
                            <div class="area">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        </div>
                        <?php if ($collections = Yii::$app->user->identity->service->getCollections()): ?>
                            <div class="collection-choice_existing">
                                <div class="collection-box">
                                    <?php foreach ($collections as $collection): ?>
                                        <?php $this->render('includes/_collection', ['collection' => $collection]); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



