<?php

namespace common\modules\artist\models\data;

use common\modules\artist\components\behaviors\ArtistBehavior;
use common\modules\artist\models\query\ArtistQuery;
use common\modules\artist\models\service\ArtistService;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "artist".
 *
 * @property int $id ID
 * @property string $name Имя
 * @property int|null $born Дата рождения
 * @property int|null $died Дата смерти
 * @property string|null $description Описание
 * @property string|null $image_name Изображение
 * @property float|null $rating Рейтинг
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted ID
 */
class Artist extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    public UploadedFile|string|null $image = null;

    public ?ArtistService $service = null;

    /** {@inheritdoc} */
    public function init(): void
    {
        $this->service = new ArtistService($this);

        parent::init();
    }

    /** {@inheritdoc} */
    public static function tableName(): string
    {
        return 'artist';
    }

    /** {@inheritdoc} */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::class,
            ],
            'mainBehavior' => [
                'class' => ArtistBehavior::class,
            ]
        ];
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['name',], 'required'],
            [['is_deleted'], 'integer'],
            [['rating'], 'number'],
            [['name', 'born', 'died', 'description', 'image_name'], 'string', 'max' => 255],
            [['image'], 'required', 'on' => self::SCENARIO_CREATE],
            [
                ['image'],
                'image',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, webp, png',
                'maxFiles' => 1,
                'maxSize' => 1024 * 1024 * 2,
            ],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'born' => 'Дата рождения',
            'died' => 'Дата смерти',
            'description' => 'Описание',
            'image_name' => 'Изображение',
            'rating' => 'Рейтинг',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'is_deleted' => 'В архиве',
        ];
    }

    /** {@inheritdoc} */
    public static function find(): ArtistQuery
    {
        return new ArtistQuery(get_called_class());
    }
}
