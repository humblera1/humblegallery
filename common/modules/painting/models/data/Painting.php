<?php

namespace common\modules\painting\models\data;

use common\modules\artist\models\data\Artist;
use common\modules\painting\models\query\PaintingQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii2tech\ar\linkmany\LinkManyBehavior;

/**
 * This is the model class for table "painting".
 *
 * @property int $id ID
 * @property string $title Название
 * @property int|null $start_date Дата начала
 * @property int|null $end_date Дата завершения
 * @property float|null $rating Рейтинг
 * @property int $artist_id Художник
 * @property int $created_at Дата добавления
 * @property int $updated_at Дата обновления
 * @property int|null $is_deleted В архиве
 *
 * @property Artist $artist
 */
class Painting extends ActiveRecord
{
    public ?array $movements = null;

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
        ];
    }

    public function getArtist(): ActiveQuery
    {
        return $this->hasOne(Artist::class, ['id' => 'artist_id']);
    }

    public static function find(): PaintingQuery
    {
        return new PaintingQuery(get_called_class());
    }
}
