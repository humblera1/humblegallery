<?php

use common\modules\artist\models\search\ArtistSearch;
use common\modules\movement\models\data\Movement;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use common\widgets\FilterWidget;
use common\widgets\SearchWidget;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var $model ArtistSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Художники';

$this->registerJs(<<<JS
    let searchFormData = [];
    let filtersFormData = [];
    
    const getCombinedData = () => {
        return [...filtersFormData, ...searchFormData];
    }

    const reloadContent = () => {
        return $.pjax.reload({
            container: '#artists-pjax-container',
            type: 'POST',
            data: getCombinedData(),
            push: false,
            replace: false
        })
    }

    $(document).on('search:applied', function (event, formData) {
        searchFormData = formData;
        reloadContent();
    });

    $(document).on('filters:applied', function (event, formData) {
        filtersFormData = formData;
        reloadContent();
    });
JS);

?>

<div class="artists">
    <?= FilterWidget::widget([
        'searchModel' => $model,
        'filters' => [
            'Направления' => Movement::class,
            'Жанры' => Subject::class,
            'Техники' => Technique::class,
        ],
    ]) ?>
    <div class="artists__content">
        <section class="artists__header">
            <h1 class="title">Художники</h1>
            <?= SearchWidget::widget([
                'searchModel' => $model,
                'field' => 'name',
            ]) ?>
        </section>
        <?php Pjax::begin(['id' => 'artists-pjax-container', 'enablePushState' => false]) ?>
            <?= $this->render('includes/_content', ['provider' => $dataProvider]) ?>
        <?php Pjax::end() ?>
    </div>
</div>
