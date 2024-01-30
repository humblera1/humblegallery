<?php

namespace common\modules\collection\models\data;

use common\modules\painting\models\data\Painting;
use common\modules\user\models\data\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Collection extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName(): string
    {
        return '{{%collection}}';
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
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
}