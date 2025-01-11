<?php

namespace common\modules\user\models\forms;

use common\components\services\AuthService;
use common\modules\user\models\data\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    public ?string $email = null;

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
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     * @throws Exception
     */
    public function sendEmail(): bool
    {
        $user = AuthService::findUserByEmail($this->email);

        if ($user && $user->service->regenerateVerificationToken()) {
            $verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/verify-email', 'token' => $user->verification_token]);

            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                    [
                        'verifyLink' => $verifyLink,
                        'username' => $user->username,
                    ]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject('Подтверждение почты на ' . Yii::$app->name)
                ->send();
        }

        return false;
    }
}
