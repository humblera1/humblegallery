<?php

namespace common\modules\subject\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\subject\models\data\Subject]].
 *
 * @see \common\modules\subject\models\data\Subject
 */
class TechniqueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\subject\models\data\Subject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\subject\models\data\Subject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
