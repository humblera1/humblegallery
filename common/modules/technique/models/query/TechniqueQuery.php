<?php

namespace common\modules\technique\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\technique\models\data\Technique]].
 *
 * @see \common\modules\technique\models\data\Technique
 */
class TechniqueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\technique\models\data\Technique[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\technique\models\data\Technique|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
