<?php

namespace common\modules\admin\models\form;

use common\models\Admin;
use Yii;
use yii\db\Query;

class AdminForm extends Admin
{
    const SCENARIO_CREATE = 'create';

    public ?string $password = null;
    public ?string $role = null;

    public function rules(): array
    {
        return [
            [['username', 'status', 'email'], 'required'],
            [['password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['username'], 'unique', 'targetAttribute' => 'username'],
            [['email'], 'unique', 'targetAttribute' => 'email'],
            [['username', 'password', 'email'], 'string'],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 8],

            [['role'], 'in', 'range' => array_keys($this->getRoleList())],
        ];
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'password' => 'Пароль',
            'role' => 'Роль',
        ]);
    }

    public function edit(): bool
    {
        if ($this->password) {
            $this->setPassword($this->password);
        }

        return $this->save();
    }

    public function register(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        if ($this->validate()) {
            $admin = new Admin();

            $admin->username = $this->username;
            $admin->email = $this->email;

            $admin->setPassword($this->password);
            $admin->generateAuthKey();

            if ($admin->save()) {
                $auth = Yii::$app->authManager;
                $auth->assign($auth->getRole($this->role), $admin->getId());

                $this->id = $admin->getId();

                $transaction->commit();

                return true;
            }
        }

        $transaction->rollBack();

        return false;
    }

    public function getRoleList()
    {
        return (new Query())->from('auth_item')
            ->select(['name', 'description'])
            ->where(['!=', 'name', 'superadmin'])
            ->indexBy('name')
            ->all();
    }
}