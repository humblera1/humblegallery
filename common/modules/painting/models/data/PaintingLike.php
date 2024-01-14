<?php

namespace common\modules\painting\models\data;

use common\modules\painting\models\query\PaintingLikeQuery;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\user\models\data\User;
use common\modules\user\models\query\UserQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "painting_likes".
 *
 * @property int $id ID
 * @property int $painting_id Картина
 * @property int $user_id Пользователь
 *
 * @property Painting $painting
 * @property User $user
 */
class PaintingLike extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'painting_likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['painting_id', 'user_id'], 'required'],
            [['painting_id', 'user_id'], 'integer'],
            [['painting_id'], 'exist', 'skipOnError' => true, 'targetRelation' => 'painting'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetRelation' => 'user'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'painting_id' => Yii::t('app', 'Картина'),
            'user_id' => Yii::t('app', 'Пользователь'),
        ];
    }

    /**
     * Gets query for [[Painting]].
     */
    public function getPainting(): ActiveQuery|PaintingQuery
    {
        return $this->hasOne(Painting::class, ['id' => 'painting_id']);
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser(): ActiveQuery|UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\painting\models\query\PaintingLikeQuery the active query used by this AR class.
     */
    public static function find(): PaintingLikeQuery
    {
        return new PaintingLikeQuery(get_called_class());
    }
}
