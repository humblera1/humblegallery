<?php

use common\helpers\Html;
use common\modules\movement\models\data\Movement;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @var $searchModel ActiveRecord
 * @var $model ActiveRecord
 * @var $title string
 */
?>

<div class="filter-section">
    <div class="filter-section__caption">
        <p class="filter-section__title"><?= $title ?></p>
        <div class="filter-section__actions">
            <div class="filter-section__badge">
                <span> 0 </span>
            </div>
            <div class="filter-section__minus">
                <?= Html::icon('dash'); ?>
            </div>
        </div>
    </div>
    <div class="filter-section__list">
        <?= $this->render('_list', ['searchModel' => $searchModel, 'model' => $model]); ?>
    </div>
    <div class="filter-section__basement">
        <span id="open-filter"> ещё... </span>
    </div>
</div>
