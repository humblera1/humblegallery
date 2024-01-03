<?php

namespace common\modules\painting\models\data;

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\painting\models\service\PaintingService;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii2tech\ar\linkmany\LinkManyBehavior;

/**
 * This is the model class for table "painting".
 *
 * @property int $id ID
 * @property string $title Название
 * @property int|null $start_date Дата начала
 * @property int|null $end_date Дата завершения
 * @property float|null $rating Рейтинг
 * @property string $image_name Путь к изображению
 * @property int $artist_id Художник
 * @property int $created_at Дата добавления
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted В архиве
 *
 * @property Artist $artist
 */
class Painting extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $image = null;

    public ?PaintingService $service = null;

    public function init(): void
    {
        $this->service = new PaintingService($this);

        parent::init();
    }

    public static function tableName(): string
    {
        return 'painting';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'linkMany' => [
                'class' => LinkManyBehavior::class,
                'relation' => 'movements',
                'relationReferenceAttribute' => 'movementIds',
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['title', 'end_date', 'artist_id'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['start_date', 'end_date'], 'date', 'format' => 'php:d.m.Y'],
            [['start_date', 'end_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['artist_id'], 'integer'],
            [['artist_id'], 'exist', 'targetRelation' => 'artist'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 1],

//            [['movements'], 'each', 'rule' => ['integer']],
            [['movementIds'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'start_date' => 'Дата начала',
            'end_date' => 'Дата завершения',
            'rating' => 'Рейтинг',
            'artist_id' => 'Художник',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'is_deleted' => 'В архиве',
            'image' => 'Изображение',
            'movementIds' => 'Направления',
        ];
    }

    public function getArtist(): ActiveQuery
    {
        return $this->hasOne(Artist::class, ['id' => 'artist_id']);
    }

    public function getMovements(): ActiveQuery
    {
        return $this->hasMany(Movement::class, ['id' => 'movement_id'])
            ->viaTable('movement_painting', ['painting_id' => 'id']);
    }

    public static function find(): PaintingQuery
    {
        return new PaintingQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($imageName = $this->saveImage()) {
            $this->image_name = $imageName;
            return parent::beforeSave($insert);
        }

        return false;
    }

    public function saveImage()
    {
        $this->image = UploadedFile::getInstance($this, 'image');
        $uploadPath = $this->getUploadPath();

        $imageName = $this->title . '.' . $this->image->extension;
        $imagePath = $uploadPath . '/' . $imageName;

        if ($this->image->saveAs($imagePath)) {
            return $imageName;
        }

        return false;
    }

    public function getUploadPath(): string
    {
        return Url::to('@common/uploads/paintings');
    }
}
