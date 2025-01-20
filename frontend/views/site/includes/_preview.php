<?php

use common\helpers\Html;
use common\modules\painting\models\search\PaintingSearch;
use common\widgets\SearchWidget;
use yii\web\View;

/**
 * @var View $this
 */

?>

<div class="main-preview">
    <div class="main-preview__info">
        <h1 class="main-preview__title">
            <span>humble</span><span>gallery</span>
        </h1>
        <p class="main-preview__subtitle">
            Погрузитесь в мир искусства, создавайте коллекции и открывайте истории великих мастеров.
        </p>
    </div>
    <div class="main-preview__image">
        <section class="main-preview__section">
            <div class="main-preview__block main-preview__block_search">
                <p class="main-preview__label main-preview__label_search">Поиск по картинам</p>
                <?= SearchWidget::widget([
                    'searchModel' => new PaintingSearch(),
                    'field' => 'title',
                    'placeholder'=> 'Название...',
                ]) ?>
            </div>
            <a class="main-preview__block main-preview__block_gallery" href="<?= Yii::$app->urlManager->createUrl(['painting/default/index']) ?>">
                <?= Html::icon('art') ?>
                <p class="main-preview__label main-preview__label_gallery">Галерея</p>
            </a>
        </section>
        <img src="/images/main.png" alt="Main Image">
    </div>
</div>