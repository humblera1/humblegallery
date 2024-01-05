<?php

namespace common\modules\movement\models\data;

use common\modules\movement\models\query\MovementQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "movement".
 *
 * @property int $id ID
 * @property string|null $name Направление
 */
class Movement extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'movement';
    }

    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Направление'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MovementQuery the active query used by this AR class.
     */
    public static function find(): MovementQuery
    {
        return new MovementQuery(get_called_class());
    }
}
