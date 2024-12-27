<?php

namespace common\widgets;

use common\components\traits\widgets\WithCustomPath;
use yii\base\Widget;
use yii\db\ActiveRecord;

class SearchWidget extends Widget
{
    use WithCustomPath;

    public ActiveRecord $searchModel;

    public string $field;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'field' => $this->field,
        ]);
    }
}