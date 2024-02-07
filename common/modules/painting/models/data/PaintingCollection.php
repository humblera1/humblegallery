<?php

namespace common\modules\painting\models\data;

use common\modules\collection\models\data\Collection;
use common\modules\collection\models\query\PaintingCollectionQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $painting_id
 * @property int $collection_id
 * @property int $created_at
 *
 * @property Painting $painting
 * @property Collection $collection
 */

class PaintingCollection extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%painting_collection}}';
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['painting_id', 'collection_id'], 'required'],
            [['painting_id', 'collection_id'], 'integer'],
            [['painting_id', 'collection_id'], 'unique', 'targetAttribute' => ['painting_id', 'collection_id']],
            [['collection_id'], 'exist', 'targetRelation' => 'collection'],
            [['painting_id'], 'exist', 'targetRelation' => 'painting'],
        ];
    }

    public function getCollection(): ActiveQuery
    {
        return $this->hasOne(Collection::class, ['id' => 'collection_id']);
    }

    public function getPainting(): ActiveQuery
    {
        return $this->hasOne(Painting::class, ['id' => 'painting_id']);
    }

    public static function find(): PaintingCollectionQuery
    {
        return new PaintingCollectionQuery(get_called_class());
    }
}