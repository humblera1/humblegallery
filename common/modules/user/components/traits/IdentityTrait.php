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
        return $this->auth_key;
    }

    /** {@inheritdoc} */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Find User by provided email.
     */
    public static function findByEmail(string $email): ?User
    {
        // todo: not blocked

        return parent::findOne(['email' => $email]);
    }
}