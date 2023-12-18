<?php

namespace common\modules\artist\models\data;

use common\modules\artist\models\query\ArtistQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "artist".
 *
 * @property int $id ID
 * @property string $name Имя
 * @property int|null $born Дата рождения
 * @property int|null $died Дата смерти
 * @property string|null $description Описание
 * @property string|null $image_path Изображение
 * @property float|null $rating Рейтинг
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted ID
 */
class Artist extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'artist';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ]
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['born', 'died', 'created_at', 'updated_at', 'is_deleted'], 'integer'],
            [['rating'], 'number'],
            [['name', 'description', 'image_path'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'born' => 'Дата рождения',
            'died' => 'Дата смерти',
            'description' => 'Описание',
            'image_path' => 'Изображение',
            'rating' => 'Рейтинг',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'is_deleted' => 'В архиве',
        ];
    }

    public static function find()
    {
        return new ArtistQuery(get_called_class());
    }
}
