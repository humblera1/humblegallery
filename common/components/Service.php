<?php

namespace common\components;

use yii\db\ActiveRecord;

class Service
{
    protected ActiveRecord $model;

    public function __construct(ActiveRecord $model)
    {
        $this->model = $model;
    }
}