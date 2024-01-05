<?php

namespace common\modules\painting\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\painting\models\data\Painting]].
 *
 * @see \common\modules\painting\models\data\Painting
 */
class PaintingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
