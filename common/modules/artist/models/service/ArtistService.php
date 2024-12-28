<?php

namespace common\modules\artist\models\service;

use common\components\Service;
use common\modules\artist\models\data\Artist;

/**
 * @property Artist $model
 */
class ArtistService extends Service
{
    /**
     * Retrieves the main image path for the painting
     */
    public function getImage(): string
    {
        $model = $this->model;

        return '/uploads/images/artists/' . $model->image_name;
    }

    public function getLimitedMovementNames(int $limit = 3): array
    {
        $movementNames = [];

        if (!$this->model->isRelationPopulated('paintings')) {
            return $movementNames;
        }

        foreach ($this->model->paintings as $painting) {
            if ($painting->isRelationPopulated('movements')) {
                foreach ($painting->movements as $movement) {
                    $movementNames[] = $movement->name;
                }
            }
        }

        $movementNames = array_unique($movementNames);

        return array_slice($movementNames, 0, $limit);
    }
}