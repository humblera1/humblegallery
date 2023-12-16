<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\data\User]].
 *
 * @see \common\models\data\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\data\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\data\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
