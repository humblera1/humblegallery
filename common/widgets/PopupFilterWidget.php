<?php

namespace common\widgets;

use common\components\traits\widgets\WithCustomPath;
use common\components\widgets\FilterSection;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\db\ActiveRecord;

class PopupFilterWidget extends Widget
{
    use WithCustomPath;

    /**
     * Модель, используемая для формирования фильтров.
     */
    public ActiveRecord $searchModel;

    /**
     * @var array[] Массив конфигураций фильтров
     * @see FilterSection
     */
    public array $sections = [];

    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->initializeSections();
    }

    public function run()
    {
        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'sections' => $this->sections,
        ]);
    }

    /**
     * @throws InvalidConfigException
     */
    private function initializeSections(): void
    {
        foreach ($this->sections as $key => $sectionConfig) {
            $this->sections[$key] = Yii::createObject(FilterSection::class, $sectionConfig);
        }
    }
}