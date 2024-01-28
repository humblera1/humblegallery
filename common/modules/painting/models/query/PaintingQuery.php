<?php

namespace common\modules\painting\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\modules\painting\models\data\Painting]].
 *
 * @see Painting
 */
class PaintingQuery extends ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return \common\modules\painting\models\data\Painting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\painting\models\data\Painting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
