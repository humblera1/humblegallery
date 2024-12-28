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
}