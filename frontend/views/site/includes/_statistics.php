<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var array $statistics
 */

?>

<div class="main-statistics">
    <h2 class="main__title">В цифрах</h2>
    <div class="main-statistics__container">
        <div class="main-statistics__content">
            <div class="main-statistics__items">
                <?php foreach ($statistics as $item): ?>
                    <div class="main-statistics__item">
                        <div class="main-statistics__icon">
                            <?= Html::icon($item['icon']); ?>
                        </div>
                        <div class="main-statistics__info">
                            <p class="main-statistics__title"><?= $item['title'] ?></p>
                            <p class="main-statistics__subtitle"><?= $item['subtitle'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>