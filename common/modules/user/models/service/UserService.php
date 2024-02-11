<?php

namespace common\modules\user\models\service;

use common\components\Service;
use common\modules\collection\models\data\Collection;
use common\modules\user\models\data\User;
use Yii;
use yii\base\Exception;

/**
 * @property User $model
 */

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

    /**
     * Validates password
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->model->password_hash);
    }

    /**
     * Returns array of user's collections or false if no collections are found
     *
     * @return bool|Collection[]
     */
    public function getCollections(): bool|array
    {
        $collections = $this->model->getCollections()
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        return empty($collections) ? false : $collections;
    }

    /**
     * Returns bool flag if user has collections
     */
    public function hasCollections(): bool
    {
       return $this->model->getCollections()->exists();
    }

    public function getFavorites(): array
    {
        return $this->model
            ->getLikedPaintings()
            ->all();
    }
}
