<?php

namespace common\modules\artist\models\query;

use common\modules\artist\models\data\Artist;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\modules\artist\models\data\Artist]].
 *
 * @see Artist
 */
class ArtistQuery extends ActiveQuery
{
    public function filterByMovement(int|array $movementIds): ArtistQuery
    {
        return $this->joinWith(['paintings.movements' => function($query) use ($movementIds) {
            $query->andWhere(['movement.id' => $movementIds]);
        }]);
    }

    public function filterBySubject(int|array $subjectIds): ArtistQuery
    {
        return $this->joinWith(['paintings.subjects' => function($query) use ($subjectIds) {
            $query->andWhere(['subject.id' => $subjectIds]);
        }]);
    }

    public function filterByTechnique(int|array $techniqueIds): ArtistQuery
    {
        return $this->joinWith(['paintings.technique' => function($query) use ($techniqueIds) {
            $query->andWhere(['technique.id' => $techniqueIds]);
        }]);
    }

    public function all($db = null): Artist|array
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }
}
