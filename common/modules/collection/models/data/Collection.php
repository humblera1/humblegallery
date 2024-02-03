<?php

namespace common\modules\collection\models\data;

use common\modules\collection\models\query\CollectionQuery;
use common\modules\painting\models\data\Painting;
use common\modules\user\models\data\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property bool $is_private
 * @property bool $is_archived
 * @property int $created_at
 *
 * @property User $user
 * @property Painting[] $paintings
 *
 */

class Collection extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName(): string
    {
        return '{{%collection}}';
    }

    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
            ],
        ];
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 32],
            [['is_private', 'is_archived'], 'boolean'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'targetRelation' => 'user'],

        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'user_id' => 'Пользователь',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPaintings(): ActiveQuery
    {
        return $this->hasMany(Painting::class, ['id' => 'painting_id'])
            ->viaTable('{{%collection_paintings}}', ['collection_id' => 'id']);
    }

    /** {@inheritdoc} */
    public static function find(): CollectionQuery
    {
        return new CollectionQuery(get_called_class());
    }
}