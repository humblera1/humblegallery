<?php

namespace common\modules\painting\models\data;

use common\components\behaviors\FileSaveBehavior;
use common\components\behaviors\SelfHealingUrlBehavior;
use common\modules\artist\models\data\Artist;
use common\modules\collection\models\data\Collection;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\painting\models\service\PaintingService;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use Exception;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii2tech\ar\linkmany\LinkManyBehavior;

/**
 * This is the model class for table "painting".
 *
 * @property int $id ID
 * @property string $title Название
 * @property string $description Описание
 * @property string|null $start_date Дата начала
 * @property string $end_date Дата завершения
 * @property float|null $rating Рейтинг
 * @property string $image_name Путь к изображению
 * @property int $technique_id Техника
 * @property int $artist_id Художник
 * @property int $created_at Дата добавления
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted В архиве
 *
 * @property Artist $artist Художник
 * @property Technique $technique Техника
 * @property Movement[] $movements Направления
 * @property Subject[] $subjects Жанры
 * @property PaintingLike[] $likes Отметки 'Нравится'
 * @property PaintingCollection[] $paintingCollections Коллекции
 * @property Collection[] $collections Коллекции
 *
 * @method SelfHealingUrlBehavior getSelfHealingUrl Generate a self-healing URL for the painting
 */
class Painting extends ActiveRecord
{

    public UploadedFile|string|null $image = null;

    public ?PaintingService $service = null;

    /** {@inheritdoc} */
    public function init(): void
    {
        $this->service = new PaintingService($this);

        parent::init();
    }

    /** {@inheritdoc} */
    public static function tableName(): string
    {
        return 'painting';
    }

    /** {@inheritdoc} */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'movements' => [
                'class' => LinkManyBehavior::class,
                'relation' => 'movements',
                'relationReferenceAttribute' => 'movementIds',
            ],
            'subjects' => [
                'class' => LinkManyBehavior::class,
                'relation' => 'subjects',
                'relationReferenceAttribute' => 'subjectIds',
            ],
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
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
                'directoryPath' => Yii::$app->params['paintingsPath'],
                'thumbnailDirectoryPath' => Yii::$app->params['paintingsThumbnailPath'],
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
            [
                [
                    'title',
                    'end_date',
                    'artist_id',
                    'technique_id',
                    'movementIds',
                    'subjectIds'
                ],
                'required'
            ],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y'],
            [['artist_id'], 'integer'],
            [['artist_id'], 'exist', 'targetRelation' => 'artist'],
            [['technique_id'], 'integer'],
            [['technique_id'], 'exist', 'targetRelation' => 'technique'],
            [['title'], 'validateImageRequired'],
            [
                ['image'],
                'image',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, webp, png',
                'maxFiles' => 1,
                'maxSize' => 1024 * 1024 * 2,
            ],
            [['artist_id'], 'filter', 'filter' => 'intval'],
            [['movementIds', 'subjectIds'], 'safe'],
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
            'title' => 'Название',
            'start_date' => 'Год начала',
            'end_date' => 'Год завершения',
            'rating' => 'Рейтинг',
            'technique_id' => 'Техника',
            'artist_id' => 'Художник',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'is_deleted' => 'В архиве',
            'image' => 'Изображение',
            'movementIds' => 'Направления',
            'subjectIds' => 'Жанры',
        ];
    }

    public function beforeSave($insert): bool
    {
        try {
            $this->saveNewMovements();
            $this->saveNewSubjects();
        } catch (Exception) {
            return false;
        }

        return parent::beforeSave($insert);
    }

    public function getTechnique(): ActiveQuery
    {
        return $this->hasOne(Technique::class, ['id' => 'technique_id']);
    }

    public function getArtist(): ActiveQuery
    {
        return $this->hasOne(Artist::class, ['id' => 'artist_id']);
    }

    public function getSubjects(): ActiveQuery
    {
        return $this->hasMany(Subject::class, ['id' => 'subject_id'])
            ->viaTable('subject_painting', ['painting_id' => 'id']);
    }

    public function getMovements(): ActiveQuery
    {
        return $this->hasMany(Movement::class, ['id' => 'movement_id'])
            ->viaTable('movement_painting', ['painting_id' => 'id']);
    }

    public function getLikes(): ActiveQuery
    {
        return $this->hasMany(PaintingLike::class, ['painting_id' => 'id']);
    }

    public function getPaintingCollections(): ActiveQuery
    {
        return $this->hasMany(PaintingCollection::class, ['painting_id' => 'id']);
    }

    public function getCollections(): ActiveQuery
    {
        return $this->hasMany(Collection::class, ['id' => 'collection_id'])
            ->via('paintingCollections');
    }

    /** {@inheritdoc} */
    public static function find(): PaintingQuery
    {
        return new PaintingQuery(get_called_class());
    }

    /**
     * Saves the new movements associated with the painting model
     *
     * @throws Exception if there is an error saving new Movement model
     */
    protected function saveNewMovements(): void
    {
        $newIds = [];

        foreach ($this->movementIds as $movementToSave) {
            if (!Movement::findOne($movementToSave)) {
                $movement = new Movement();
                $movement->name = $movementToSave;

                if ($movement->save()) {
                    $newIds[] = $movement->id;

                    continue;
                }

                throw new Exception('Ошибка при сохранении направления');
            }

            $newIds[] = $movementToSave;
        }

        $this->movementIds = $newIds;
    }

    /**
     * Saves the new subjects associated with the painting model
     *
     * @throws Exception if there is an error saving new Subject model
     */
    protected function saveNewSubjects(): void
    {
        $newIds = [];

        foreach ($this->subjectIds as $subjectToSave) {
            if (!Subject::findOne($subjectToSave)) {
                $subject = new Subject();
                $subject->name = $subjectToSave;

                if ($subject->save()) {
                    $newIds[] = $subject->id;

                    continue;
                }

                throw new Exception('Ошибка при сохранении жанра');
            }

            $newIds[] = $subjectToSave;
        }

        $this->subjectIds = $newIds;
    }
}
