<?php

namespace common\modules\user\models\data;

use common\modules\user\models\query\UserQuery;
use common\modules\user\models\service\UserService;
use traits\IdentityTrait;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $username Логин
 * @property string|null $email
 * @property string $password_hash
 * @property string|null $name Имя
 * @property string|null $surname Фамилия
 * @property int|null $is_verified Подтверждён
 * @property int|null $is_blocked Заблокирован
 * @property int $created_at Создан
 * @property int $updated_at Обновлён
 */
class User extends ActiveRecord implements IdentityInterface
{
    use IdentityTrait;

    public ?UserService $service = null;

    public function init(): void
    {
        $this->service = new UserService($this);

        parent::init();
    }
    public static function tableName(): string
    {
        return 'user';
    }


    public function rules(): array
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['is_verified', 'is_blocked', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'password_hash', 'name', 'surname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'is_verified' => 'Подтверждён',
            'is_blocked' => 'Заблокирован',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
        ];
    }

    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }
}
