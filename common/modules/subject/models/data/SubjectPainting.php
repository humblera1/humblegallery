<?php

namespace common\modules\subject\models\data;

use yii\db\ActiveRecord;

class SubjectPainting extends ActiveRecord
{
    public static function tableName(): string
    {
        return "subject_painting";
    }
}