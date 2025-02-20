<?php

namespace common\modules\user\models\forms;

use common\modules\user\models\data\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public string|null $name = null;
    public string|null $surname = null;
    public string|null $username = null;
    public string|null $email = null;

    public string|null $password = null;
    public string|null $passwordAgain = null;

    public string|null $captcha = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'surname',
                    'username',
                    'email',
                ],
                'trim',
            ],
            [
                [
                    'username',
                    'email',
                    'password',
                    'passwordAgain'
                ],
                'required'
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
            ],
            [
                'username',
                'string',
                'min' => 2,
                'max' => 255
            ],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => User::class,
            ],
            [
                'password',
                'string',
                'min' => Yii::$app->params['user.passwordMinLength']
            ],
            [
                'passwordAgain',
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают',
            ],
            ['captcha', 'required'],
            ['captcha', 'captcha', 'captchaAction'=>'/auth/captcha'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'username' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'passwordAgain' => 'Пароль ещё раз',
            'captcha' => 'Введите код с картинки',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function signup(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = new User();

        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->username = $this->username;
        $user->email = $this->email;

        $user->service->setPassword($this->password);

        $user->service->generateAuthKey();
        $user->service->generateVerificationToken();

        $transaction = Yii::$app->db->beginTransaction();

        $success = $user->save();

        if (!$success) {
            $transaction->rollBack();

            return false;
        }

        $success = $this->sendEmail($user);

        if (!$success) {
            $this->addError('email', 'Не удалось отправить письмо с подтверждением.');

            $transaction->rollBack();

            return false;
        }

        $transaction->commit();

        return Yii::$app->user->login($user, Yii::$app->params['user.loginDuration']);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be sent
     * @return bool whether the email was sent
     */
    protected function sendEmail(User $user): bool
    {
        $verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/verify-email/', 'token' => $user->verification_token]);

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                [
                    'verifyLink' => $verifyLink,
                    'username' => $user->username,
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['senderName']])
            ->setTo($this->email)
            ->setSubject(Yii::$app->name . '. ' . 'Регистрация.')
            ->send();
    }
}
