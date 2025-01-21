<?php

namespace common\modules\user\models\forms;

use common\components\services\AuthService;
use common\modules\user\models\data\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public string|null $email = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['is_blocked' => false],
                'message' => 'Пользователь с указанным адресом не найден.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was sent.
     * @throws Exception
     */
    public function sendEmail(): bool
    {
        $user = AuthService::findUserByEmail($this->email);

        if ($user && $user->service->regeneratePasswordResetToken()) {
            $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);

            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                    ['resetLink' => $resetLink]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject('Password reset for ' . Yii::$app->name)
                ->send();
        }

        return false;
    }
}
