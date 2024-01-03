<?php

namespace common\modules\painting\models\service;

use common\components\Service;

class PaintingService extends Service
{
    public function getImagePath(): string
    {
        return '@web/uploads/paintings/' . $this->model->title . '.jpg';
    }
}