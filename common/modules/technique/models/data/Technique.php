<?php

namespace common\modules\technique\models\data;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "technique".
 *
 * @property int $id ID
 * @property string $name Техника
 */
class Technique extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technique';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Техника'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\technique\models\query\TechniqueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\technique\models\query\TechniqueQuery(get_called_class());
    }
}
