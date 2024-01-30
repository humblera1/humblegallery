<?php

namespace common\modules\painting\models\data;

use yii\db\ActiveRecord;

class PaintingCollection extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%painting_collection}}';
    }
}