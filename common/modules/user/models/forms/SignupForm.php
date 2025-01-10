<?php

namespace common\modules\user\models\forms;

use common\modules\user\models\data\User;
use Yii;
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
            ['captcha', 'captcha'],
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
     * @throws \yii\base\Exception
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

        $user->setPassword($this->password);

        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if (!$user->save() || !$this->sendEmail($user)) {
            return false;
        }

        return Yii::$app->user->login($user, Yii::$app->params['user.loginDuration']);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return true;

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
