<?php

namespace common\modules\artist\models\service;

use common\components\Service;
use common\modules\artist\models\data\Artist;
use DateTime;

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
        return '/uploads/images/artists/' . $this->model->image_name;
    }

    public function getYears(): string
    {
        $model = $this->model;

        $bornYear = $model->born ? (new DateTime($model->born))->format('Y') : null;
        $diedYear = $model->died ? (new DateTime($model->died))->format('Y') : null;

        if ($bornYear && $diedYear) {
            return "$bornYear — $diedYear";
        }

        return $bornYear ?? $diedYear ?? '—';
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