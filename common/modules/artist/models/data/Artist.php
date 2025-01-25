<?php

namespace common\modules\artist\models\data;

use common\components\behaviors\FileSaveBehavior;
use common\components\behaviors\SelfHealingUrlBehavior;
use common\modules\artist\models\query\ArtistQuery;
use common\modules\artist\models\service\ArtistService;
use common\modules\painting\models\data\Painting;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "artist".
 *
 * @property int $id ID
 * @property string $name Имя
 * @property string $slug Слаг
 * @property int|null $born Дата рождения
 * @property int|null $died Дата смерти
 * @property string|null $description Описание
 * @property string|null $image_name Изображение
 * @property float|null $rating Рейтинг
 * @property int $created_at Дата создания
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted ID
 *
 * @property Painting[] $paintings
 */
class Artist extends ActiveRecord
{
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
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::class,
            ],
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ],
            'selfHealingUrl' => [
                'class' => SelfHealingUrlBehavior::class,
            ],
            'fileSave' => [
                'class' => FileSaveBehavior::class,
                'withThumbnail' => true,
                'fileName' => '{slug}-{id}{timestamp}.{extension}',
                'fileAttribute' => 'image',
                'fileNameAttribute' => 'image_name',
                'directoryPath' => Yii::$app->params['artistsPath'],
                'thumbnailDirectoryPath' => Yii::$app->params['artistsThumbnailPath'],
                'targetExtension' => 'webp',
                'targetSize' => 100 * 1024,
                'targetThumbnailSize' => 30 * 1024,
                'updateWhen' => ['slug'],
            ],
        ];
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name', 'born', 'died', 'image_name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [
                ['image'],
                'image',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, webp, png',
                'maxFiles' => 1,
                'maxSize' => 1024 * 1024 * 2,
            ],
            [['name'], 'validateImageRequired'],
        ];
    }

    /**
     * Custom validation method to check if the image is required.
     */
    public function validateImageRequired(): void
    {
        if ($this->isNewRecord && empty($this->image)) {
            $this->addError('image', 'Image is required for new records.');
        }
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

    public function getPaintings(): ActiveQuery
    {
        return $this->hasMany(Painting::class, ['artist_id' => 'id']);
    }
}
