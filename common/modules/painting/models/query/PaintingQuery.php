<?php

namespace common\modules\painting\models\query;

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
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

    public function filterByMovement(int|array $movementIds): PaintingQuery
    {
        return $this->joinWith(['movements' => function($query) use ($movementIds) {
            $query->andWhere([Movement::tableName() . '.id' => $movementIds]);
        }]);
    }

    public function filterBySubject(int|array $subjectIds): PaintingQuery
    {
        return $this->joinWith(['subjects' => function($query) use ($subjectIds) {
            $query->andWhere([Subject::tableName() . '.id' => $subjectIds]);
        }]);
    }

    public function filterByTechnique(int|array $techniqueIds): PaintingQuery
    {
        return $this->joinWith(['technique' => function($query) use ($techniqueIds) {
            $query->andWhere([Technique::tableName() . '.id' => $techniqueIds]);
        }]);
    }

    public function filterByArtist(int|array $artistIds): PaintingQuery
    {
        return $this->joinWith(['artist' => function($query) use ($artistIds) {
            $query->andWhere([Artist::tableName() . '.id' => $artistIds]);
        }]);
    }
}
