<?php

namespace common\modules\subject\models\data;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subject".
 *
 * @property int $id ID
 * @property string $name Жанр
 */
class Subject extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subject';
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
            'name' => Yii::t('app', 'Жанр'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\subject\models\query\TechniqueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\subject\models\query\TechniqueQuery(get_called_class());
    }
}
