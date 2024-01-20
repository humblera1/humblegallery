<?php

namespace common\modules\user\components\traits;

use common\modules\user\models\data\User;

trait IdentityTrait
{
    /** {@inheritdoc} */
    public static function findIdentity($id): ?User
    {
        return parent::findOne($id);
    }

    /** {@inheritdoc} */
    public static function findIdentityByAccessToken($token, $type = null) {}

    /** {@inheritdoc} */
    public function getId(): int
    {
        return $this->id;
    }

    /** {@inheritdoc} */
    public function getAuthKey(): string
    {
        return $this->authKey;
    }

    /** {@inheritdoc} */
    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    /**
     * Find User by provided username
     */
    public static function findByUsername(string $username): ?User
    {
        return parent::findOne(['username' => $username]);
    }
}