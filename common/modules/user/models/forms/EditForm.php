<?php

namespace common\modules\user\models\forms;

use yii\base\Model;

class EditForm extends Model
{
    public $name;
    public $surname;
    public $username;
    public $email;
    public $password;

    public function rules(): array
    {
        return [
            [['name', 'email'], 'string'],
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
        ];
    }
}