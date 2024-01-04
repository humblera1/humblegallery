<?php

namespace common\modules\painting\models\data;

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\painting\models\service\PaintingService;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use Exception;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii2tech\ar\linkmany\LinkManyBehavior;
use function PHPUnit\Framework\throwException;

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
 * @property array $movementsToSave
 *
 * @property Artist $artist
 * @property Technique $technique
 * @property Movement[] $movements
 * @property Subject[] $subjects
 */
class Painting extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $image = null;

    public ?PaintingService $service = null;
    public $movementsToSave;

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
        ];
    }

    public function rules(): array
    {
        return [
            [['title', 'end_date', 'artist_id', 'technique_id'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['start_date', 'end_date'], 'date', 'format' => 'php:d.m.Y'],
            [['start_date', 'end_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['artist_id'], 'integer'],
            [['artist_id'], 'exist', 'targetRelation' => 'artist'],
            [['technique_id'], 'integer'],
            [['technique_id'], 'exist', 'targetRelation' => 'technique'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 1],

            [['movementIds', 'subjectIds', 'movementsToSave'], 'safe'],
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
        if ($imageName = $this->saveImage()) {
            $this->image_name = $imageName;

            if (!$this->saveMovements()) {
                $this->addError('movementIds', Yii::t('app', 'Не удалось сохранить новые направления'));

                return false;
            }

            if (!$this->saveSubjects()) {
                $this->addError('subjectIds', Yii::t('app', 'Не удалось сохранить новые жанры'));

                return false;
            }

            return parent::beforeSave($insert);
        }

        return false;
    }

    public function saveMovements(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        $newIds = [];

        try {
            foreach ($this->movementIds as $movementToSave) {
                if (!Movement::findOne($movementToSave)) {
                    $movement = new Movement();
                    $movement->name = $movementToSave;

                    if ($movement->save()) {
                        $newIds[] = $movement->id;

                        continue;
                    }

                    throw new Exception();
                }

                $newIds[] = $movementToSave;
            }
        } catch (Exception) {
            $transaction->rollBack();

            return false;
        }

        $this->movementIds = $newIds;

        $transaction->commit();

        return true;
    }

    public function saveSubjects(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        $newIds = [];

        try {
            foreach ($this->subjectIds as $subjectToSave) {
                if (!Subject::findOne($subjectToSave)) {
                    $subject = new Subject();
                    $subject->name = $subjectToSave;

                    if ($subject->save()) {
                        $newIds[] = $subject->id;

                        continue;
                    }

                    throw new Exception();
                }

                $newIds[] = $subjectToSave;
            }
        } catch (Exception) {
            $transaction->rollBack();

            return false;
        }

        $this->subjectIds = $newIds;

        $transaction->commit();

        return true;
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
