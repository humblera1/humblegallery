<?php

namespace common\modules\painting\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\painting\models\data\PaintingLike]].
 *
 * @see \common\modules\painting\models\data\PaintingLike
 */
class PaintingLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\painting\models\data\PaintingLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\painting\models\data\PaintingLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
