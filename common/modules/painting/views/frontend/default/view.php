<?php

use common\helpers\Html;
use common\modules\painting\models\data\Painting;
use yii\web\View;

/**
 * @var View $this
 * @var Painting $model
 */

$this->title = $model->title;

?>

<div class="painting">
    <div class="painting__overview">
        <div class="painting__painting">
            <div class="painting__image">
                <img src="<?= $model->service->getImage() ?>" alt="<?= $model->title ?>">
            </div>
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl($model->service->getImage()) ?>" target="_blank" class="painting__action">
                <span>Открыть изображение</span>
                <?= Html::icon('square-arrow') ?>
            </a>
        </div>
        <div class="painting__container">
            <header class="painting__header">
                <h1 class="title painting__title"><?= $model->title ?></h1>
                <p class="painting__subtitle"><?= $model->service->getDateToDisplay() ?></p>
            </header>
            <div class="painting__info">
                <p class="painting__description">
                    <?= $model->description ?>
                </p>
                <div class="painting__delimiter"></div>
                <div class="painting__sections">
                    <div class="painting__section">
                        <p class="painting__section-label">Год</p>
                        <p class="painting__section-value"><?= $model->end_date ?></p>
                    </div>
                    <div class="painting__section">
                        <p class="painting__section-label">Художник</p>
                        <p class="painting__section-value"><?= $model->artist->name ?></p>
                    </div>
                    <div class="painting__section">
                        <p class="painting__section-label">Техника</p>
                        <p class="painting__section-value"><?= $model->technique->name ?></p>
                    </div>
                    <div class="painting__section">
                        <p class="painting__section-label">Жанры</p>
                        <p class="painting__section-value"><?= $model->service->getSubjectNames() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
