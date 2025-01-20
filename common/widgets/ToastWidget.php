<?php

namespace common\widgets;

use common\components\widgets\BaseWidget;

class ToastWidget extends BaseWidget
{
    public function run(): string
    {
        return $this->render('index');
    }
}