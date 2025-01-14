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

    /**
     * Filters the query to include only public collections.
     * Method adds a condition to exclude collections marked as private.
     *
     * @return CollectionQuery
     */
    public function publicOnly(): CollectionQuery
    {
        return $this->andWhere(['is_private' => false]);
    }

    /**
     * Filters the query to include only active collections.
     *
     * @return CollectionQuery
     */
    public function activeOnly(): CollectionQuery
    {
        return $this->andWhere(['is_archived' => false]);
    }
}