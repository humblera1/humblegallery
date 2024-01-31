<?php

namespace common\modules\painting\models\data;

use common\modules\collection\models\query\PaintingCollectionQuery;
use yii\db\ActiveRecord;

class PaintingCollection extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%painting_collection}}';
    }

    public static function find(): PaintingCollectionQuery
    {
        return new PaintingCollectionQuery(get_called_class());
    }
}