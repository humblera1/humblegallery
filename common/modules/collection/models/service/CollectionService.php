<?php

namespace common\modules\collection\models\service;

use common\components\Service;
use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingCollection;

/**
 * @property Collection $model
 */

class CollectionService extends Service
{
    public function getPreviewImage(): bool|string
    {
        /** @var Painting $lastPainting */
        $lastPainting = Painting::find()
            ->andFilterWhere(['c.id' => $this->model->id])
            ->joinWith('collections c')
            ->orderBy([PaintingCollection::tableName() . '.created_at' => SORT_DESC])
            ->one();

        if ($lastPainting) {
            return $lastPainting->service->getThumbnail();
        }

        return false;
    }
}