<?php

namespace common\components\services;

use common\modules\user\models\data\User;
use Yii;

class AuthService
{
    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token.
     * @return static|null
     */
    public static function findByPasswordResetToken($token): ?User
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return User::findOne([
            'password_reset_token' => $token,
            'is_blocked' => false,
        ]);
    }

    /**
     * Finds user by verification email token.
     *
     * @param string $token verify email token.
     */
    public static function findUserByVerificationToken(string $token): ?User
    {
        return User::findOne([
            'verification_token' => $token,
            'is_blocked' => false,
        ]);
    }
}