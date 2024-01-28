<?php

namespace common\modules\painting\models\query;

use Yii;

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

    /**
     * Checks the existence of a record in a related table with id of the current user
     */
    public function byCurrentUser(): PaintingLikeQuery
    {
        return $this->andWhere(['user_id' => Yii::$app->user->getId()]);
    }
}
