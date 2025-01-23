<?php

namespace common\modules\artist\models\service;

use common\components\Service;
use common\modules\artist\models\data\Artist;
use DateTime;
use Yii;

/**
 * @property Artist $model
 */
class ArtistService extends Service
{
    /**
     * Retrieves the main image path for the painting.
     */
    public function getImage(): string
    {
        return Yii::$app->params['artistsUrl'] . $this->model->image_name;
    }

    /**
     * Retrieves the thumbnail image path for the painting.
     */
    public function getThumbnail(): string
    {
        return Yii::$app->params['artistsThumbnailUrl'] . $this->model->image_name;
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

    public function getTopRatedPaintings($amount = 5): array
    {
        return $this->model->getPaintings()
            ->orderBy(['rating' => SORT_DESC])
            ->limit($amount)
            ->all();
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