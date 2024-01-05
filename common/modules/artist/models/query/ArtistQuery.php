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
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function all($db = null): Artist|array
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }
}
