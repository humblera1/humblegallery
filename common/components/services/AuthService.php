<?php

namespace common\components\services;

use common\modules\user\models\data\User;
use Yii;
use yii\db\Exception;

class AuthService
{
    protected const RESET_PASSWORD_TOKEN = 'reset-password';

    protected const VERIFICATION_TOKEN = 'verification';

    protected static function isTokenValid(string $token, string $type): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = $type === self::RESET_PASSWORD_TOKEN ? Yii::$app->params['user.passwordResetTokenExpire'] : Yii::$app->params['user.verificationTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        return self::isTokenValid($token, self::RESET_PASSWORD_TOKEN);
    }

    public static function isVerificationTokenValid(string $token): bool
    {
        return self::isTokenValid($token, self::VERIFICATION_TOKEN);
    }

    /**
     * @throws Exception
     */
    public static function verifyEmail(string $token): bool
    {
        if ($token && ($user = self::findUserByVerificationToken($token))) {
            $user->is_verified = true;
            $user->verification_token = null;

            return $user->save(false);
        }

        return false;
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token.
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token): ?User
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
        if (!self::isVerificationTokenValid($token)) {
            return null;
        }

        return User::findOne([
            'verification_token' => $token,
            'is_blocked' => false,
        ]);
    }

    /**
     * Find User by provided email.
     */
    public static function findUserByEmail(string $email): ?User
    {
        return User::findOne([
            'email' => $email,
            'is_blocked' => false,
        ]);
    }
}