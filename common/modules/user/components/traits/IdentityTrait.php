<?php

namespace traits;

use common\modules\user\models\data\User;
use Yii;

trait IdentityTrait
{
    /** {@inheritdoc} */
    public static function findIdentity($id): ?User
    {
        return parent::findOne($id);
    }

    /** {@inheritdoc} */
    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        return parent::findOne(['access_token' => $token]);
    }

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
}