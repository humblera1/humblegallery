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
        $model = $this->model;

        if ($model->name && $model->surname) {
            return $model->name . ' ' . $model->surname;
        }

        if ($model->name) {
            return $model->name;
        }

        return $model->username;
    }

    public function getAvatar(): string
    {
        return '/uploads/avatars/' . $this->model->avatar;
    }

    /**
     * @param string $password
     * @return void
     * @throws Exception
    */
    public function setPassword(string $password): void
    {
        $this->model->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Removes password reset token.
     *
     * @return void
     */
    public function removePasswordResetToken(): void
    {
        $this->model->password_reset_token = null;
    }

    /**
     * Generates 'remember me' authentication key.
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
     * @throws Exception
     */
    public function regeneratePasswordResetToken(): bool
    {
        $this->generatePasswordResetToken();

        return $this->model->save();
    }

    /**
     * @throws Exception
     */
    public function regenerateVerificationToken(): bool
    {
        $this->generateVerificationToken();

        return $this->model->save();
    }

    /**
     * Generates new password reset token.
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new email verification token.
     * @throws Exception
     */
    public function generateVerificationToken(): void
    {
        $this->model->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
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

    /**
     * Возвращает набор всех коллекций пользователя, дополнительно помечая те коллекции,
     * которые содержат переданную картину.
     *
     * @param int $paintingId
     * @return array
     */
    public function getMarkedCollections(int $paintingId): array
    {
        return $this->model->getCollections()
            ->alias('c')
            ->addSelect([
                'c.*',
                'contains_painting' => new \yii\db\Expression(
                    'CASE WHEN pc.painting_id IS NOT NULL THEN 1 ELSE 0 END'
                )
            ])
            ->andWhere(['c.is_archived' => false])
            ->leftJoin(['pc' => 'painting_collection'], 'pc.collection_id = c.id AND pc.painting_id = :paintingId', [':paintingId' => $paintingId])
            ->all();
    }

    public function getFavorites(): array
    {
        return $this->model
            ->getLikedPaintings()
            ->all();
    }
}
