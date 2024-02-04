<?php

namespace common\modules\painting\models\query;

use common\modules\painting\models\data\PaintingLike;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Connection;

/**
 * This is the ActiveQuery class for [[\common\modules\painting\models\data\PaintingLike]].
 *
 * @see \common\modules\painting\models\data\PaintingLike
 */
class PaintingLikeQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     */
    public function all($db = null): PaintingLike|array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     */
    public function one($db = null): PaintingLike|array|null
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
