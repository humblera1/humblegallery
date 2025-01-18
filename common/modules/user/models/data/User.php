<?php

namespace common\modules\user\models\data;

use common\components\behaviors\FileSaveBehavior;
use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\Painting;
use common\modules\user\components\traits\IdentityTrait;
use common\modules\user\models\query\UserQuery;
use common\modules\user\models\service\UserService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $username Логин
 * @property string|null $email
 * @property string|null $avatar
 * @property string $password_hash
 * @property string|null $name Имя
 * @property string|null $surname Фамилия
 * @property string $auth_key
 * @property string $password_reset_token Токен для сброса пароля
 * @property string $verification_token Токен для подтверждения почты
 * @property int|null $is_verified Подтверждён
 * @property int|null $is_blocked Заблокирован
 * @property int $is_closed Закрытый профиль
 * @property int $created_at Создан
 * @property int $updated_at Обновлён
 *
 * @property-read Collection[] $collections Коллекции пользователя
 * @property-read Painting[] $likedPaintings Понравившиеся картины
 *
 * @method FileSaveBehavior saveFile Save the cover file
 * @method FileSaveBehavior loadWithFile(array $dataToLoad)
 */

// todo: добавить атрибут is_blocked для сценария редактирования из админки
class User extends ActiveRecord implements IdentityInterface
{
    use IdentityTrait;

    public ?UserService $service = null;

    public bool $remove_avatar = false;

    public UploadedFile|string|null $file = null;

    public function init(): void
    {
        $this->service = new UserService($this);

        parent::init();
    }
    public static function tableName(): string
    {
        return 'user';
    }

    /** {@inheritdoc} */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'fileSave' => [
                'class' => FileSaveBehavior::class,
                'fileNameAttribute' => 'avatar',
                'fileName' => '{username}-{timestamp}.{extension}',
                'directoryPath' => Yii::$app->params['avatarsPath'],
                'removeOldFile' => 'remove_avatar',
            ],
        ];
    }

    public function rules(): array
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
                ],
                'required'
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->id]]);
                },
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
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->id]]);
                },
            ],
            [['remove_avatar'], 'boolean'],
            [['remove_avatar'], 'default', 'value' => false],
            [['file'], 'file', 'maxSize' => 2 * 1024 * 1024, 'extensions' => 'png, jpg'],
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

    public function getCollections(): ActiveQuery
    {
        return $this->hasMany(Collection::class, ['user_id' => 'id']);
    }

    // TODO: deprecated
    public function getLikedPaintings(): ActiveQuery
    {
        return $this->hasMany(Painting::class, ['id' => 'painting_id'])
            ->viaTable('{{%painting_likes}}', ['user_id' => 'id']);
    }

    public function getFavoritePaintings(): ActiveQuery
    {
        return $this->hasMany(Painting::class, ['id' => 'painting_id'])
            ->viaTable('{{%painting_likes}}', ['user_id' => 'id']);
    }
}
