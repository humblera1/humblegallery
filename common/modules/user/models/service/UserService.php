<?php

namespace common\modules\user\models\service;

use common\components\Service;

class UserService extends Service
{
    public function getName(): string
    {
        return $this->model->name . ' ' . $this->model->surname;
    }
}