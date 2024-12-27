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
     * @var array<string, ActiveRecord> $filters
     */
    public array $filters;

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
            'filters' => $this->filters,
        ]);
    }
}