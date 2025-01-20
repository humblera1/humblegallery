<?php

namespace common\widgets;

use common\components\widgets\BaseWidget;
use Yii;

class FlashWidget extends BaseWidget
{
    public function run(): string
    {
        return $this->render('index', ['flashes' => Yii::$app->session->getAllFlashes()]);
    }
}