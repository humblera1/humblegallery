<?php

namespace common\modules\painting\models\query;

use Yii;
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

    /**
     * Checks the existence of a record in a related table with id of the current user
     */
    public function byCurrentUser(): PaintingQuery
    {
        return $this->andWhere(['user_id' => Yii::$app->user->getId()]);
    }
}
