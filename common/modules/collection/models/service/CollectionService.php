<?php

namespace common\modules\collection\models\service;

use common\components\Service;
use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\Painting;

/**
 * @property Collection $model
 */

class CollectionService extends Service
{
    public function getPreviewImage(): bool|string
    {
        /** @var Painting $lastPainting */
        $lastPainting = $this->model->getPaintings()
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if ($lastPainting) {
            return $lastPainting->service->getThumbnail();
        }

        return false;
    }
}