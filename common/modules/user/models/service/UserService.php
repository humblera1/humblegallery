<?php

namespace common\modules\user\models\service;

use common\components\Service;
use Yii;
use yii\base\Exception;

class UserService extends Service
{
    public function getName(): string
    {
        return $this->model->name . ' ' . $this->model->surname;
    }

    /**
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->model->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates 'remember me' authentication key
     *
     * @throws Exception if string can't be generated
     */
    public function generateAuthKey(): void
    {
        $this->model->auth_key = Yii::$app->security->generateRandomString();
    }
}