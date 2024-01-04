<?php

namespace common\modules\painting\models\service;

use common\components\Service;

class PaintingService extends Service
{
    public function getImagePath(): string
    {
        return '/uploads/paintings/' . $this->model->image_name;
    }
}