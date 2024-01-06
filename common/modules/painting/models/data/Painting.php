<?php

namespace common\modules\painting\models\data;

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\components\behaviors\ImageBehavior;
use common\modules\painting\components\behaviors\MovementBehavior;
use common\modules\painting\components\behaviors\SubjectBehavior;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\painting\models\service\PaintingService;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use Exception;
use Yii;
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
 * @property int|null $start_date Дата начала
 * @property int|null $end_date Дата завершения
 * @property float|null $rating Рейтинг
 * @property string $image_name Путь к изображению
 * @property int $technique_id Техника
 * @property int $artist_id Художник
 * @property int $created_at Дата добавления
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted В архиве
 *
 * @property Artist $artist
 * @property Technique $technique
 * @property Movement[] $movements
 * @property Subject[] $subjects
 */
class Painting extends ActiveRecord
{
//    const SCENARIO_CREATE = 'create';

    public UploadedFile|string|null $image = null;

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
            ImageBehavior::class,
            MovementBehavior::class,
            SubjectBehavior::class,
        ];
    }

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
            [['start_date', 'end_date'], 'date', 'format' => 'php:d.m.Y'],
            [['start_date', 'end_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['artist_id'], 'integer'],
            [['artist_id'], 'exist', 'targetRelation' => 'artist'],
            [['technique_id'], 'integer'],
            [['technique_id'], 'exist', 'targetRelation' => 'technique'],
            [
                ['image'],
                'image',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, webp, png',
                'maxFiles' => 1,
                'maxSize' => 1024 * 1024 * 2,
            ],

            [['movementIds', 'subjectIds'], 'safe'],
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

    public static function find(): PaintingQuery
    {
        return new PaintingQuery(get_called_class());
    }

    public function beforeSave($insert): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            /** @see ImageBehavior::saveImage()  */
            if (!$this->saveImage()) {
                $this->addError('image', Yii::t('app', 'Не удалось сохранить изображение'));

                throw new Exception();
            }

            /** @see MovementBehavior::saveMovements()  */
            if (!$this->saveMovements()) {
                $this->addError('movementIds', Yii::t('app', 'Не удалось сохранить новые направления'));

                throw new Exception();
            }

            /** @see SubjectBehavior::saveSubjects()  */
            if (!$this->saveSubjects()) {
                $this->addError('subjectIds', Yii::t('app', 'Не удалось сохранить новые жанры'));

                throw new Exception();
            }

            if (!parent::beforeSave($insert)) {
                throw new Exception();
            }

        } catch (Exception) {
            $transaction->rollBack();

            return false;
        }

        $transaction->commit();

        return true;
    }
}
