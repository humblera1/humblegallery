<?php

namespace common\modules\movement\models\query;

use common\modules\movement\models\data\Movement;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\modules\movement\models\data\Movement]].
 *
 * @see Movement
 */
class MovementQuery extends ActiveQuery
{

    /**
     * @return Movement[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @return Movement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
