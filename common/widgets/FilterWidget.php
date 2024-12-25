<?php

namespace common\widgets;

use common\components\traits\widgets\WithCustomPath;
use yii\base\Widget;
use yii\db\ActiveRecord;

class FilterWidget extends Widget
{
    use WithCustomPath;

    /**
     * Модель, используемая для поиска.
     */
    public ActiveRecord $searchModel;

    /**
     * Модели для формирования фильтров.
     *
     * @var array<ActiveRecord> $models
     */
    public array $models;

    /**
     * Флаг, указывающий, что нужно отображать фильтр по периоду.
     */
    public bool $withPeriod = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'models' => $this->models,
        ]);
    }
}