<?php

namespace common\modules\painting\models\data;

use Yii;

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
class Painting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'painting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'artist_id', 'created_at', 'updated_at'], 'required'],
            [['start_date', 'end_date', 'artist_id', 'created_at', 'updated_at', 'is_deleted'], 'integer'],
            [['rating'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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

    /**
     * Gets query for [[Artist]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\painting\models\query\ArtistQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::class, ['id' => 'artist_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\painting\models\query\PaintingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\painting\models\query\PaintingQuery(get_called_class());
    }
}
