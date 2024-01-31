<?php

namespace common\modules\collection\models\query;

use common\modules\collection\models\data\Collection;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Connection;

class CollectionQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     */
    public function all($db = null): Collection|array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     */
    public function one($db = null): Collection|array|null
    {
        return parent::one($db);
    }

    /**
     * Checks the existence of a record in a related table with id of the current user
     */
    public function byCurrentUser(): CollectionQuery
    {
        return $this->andWhere(['user_id' => Yii::$app->user->getId()]);
    }
}