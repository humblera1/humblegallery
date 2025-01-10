<?php

namespace common\modules\user\models\forms;

use common\modules\user\models\data\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public ?string $email = null;
    public ?string $password = null;

    public ?User $_user = null;

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'validatePassword'],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
        ];
    }

    /**
     * Validate a password
     */
    public function validatePassword(string $attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->service->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверные E-mail или пароль');
            }
        }
    }

    public function login(): bool
    {
        if ($this->validate()) {

            $user = $this->getUser();

            return Yii::$app->user->login($user, 30 * 24 * 60 * 60);
        }

        return false;
    }

    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
