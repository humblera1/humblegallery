<?php

namespace common\modules\collection\models\query;

use common\modules\painting\models\data\PaintingCollection;
use Yii;
use yii\db\ActiveQuery;

class PaintingCollectionQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     */
    public function all($db = null): PaintingCollection|array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     */
    public function one($db = null): PaintingCollection|array|null
    {
        return parent::one($db);
    }
}