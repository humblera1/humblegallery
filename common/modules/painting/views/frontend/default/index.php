<?php

use common\modules\painting\models\search\PaintingSearch;
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
 * @var $model PaintingSearch
 * @var ActiveDataProvider $dataProvider
 */

MasonryAsset::register($this);
?>

<div class="page">
    <div class="page__content">
        <header class="header">
            <nav class="header__navigation">
                <div class="nav-block">
                    <div class="nav-item--logo"></div>
                    <div class="nav-item">Художники</div>
                    <div class="nav-item">Картины</div>
                    <div class="nav-item">Статьи</div>
                </div>
                <div class="nav-block">
                    <div class="nav-item">Профиль</div>
                </div>
            </nav>
        </header>

        <div class="page-container">
            <?= $this->render('includes/_sidebar', ['model' => $model]) ?>

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

