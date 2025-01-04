<?php

namespace common\widgets;

use common\components\traits\widgets\WithCustomPath;
use yii\base\Widget;

class SwiperWidget extends Widget
{
    use WithCustomPath;

    public array $paintings = [];

    public function run()
    {
        return $this->render('index', [
            'paintings' => $this->paintings,
        ]);
    }
}