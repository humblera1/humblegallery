<?php

namespace common\modules\painting\models\service;

use common\components\Service;
use yii\helpers\Url;

class PaintingService extends Service
{
    /**
     * Retrieves the main image path for the painting
     */
    public function getImage(): string
    {
        $model = $this->model;

        return '/uploads/images/paintings/' . $model->artist->name . '/' . $model->image_name;
    }

    /**
     * Retrieves the thumbnail path for the painting
     */
    public function getThumbnail(): string
    {
        $model = $this->model;
        return '/uploads/thumbnails/paintings/' . $model->artist->name . '/' . $model->title . '.webp';
    }

    /**
     * Retrieves a list of movements of the painting and return them as a links
     */
    public function getMovementsList(): string
    {
        $list = '';

        foreach ($this->model->movements as $movement) {
            $list .= '<a href="' . Url::to(['/movement/default/view', 'id' => $movement->id]) . '">' . $movement->name . '</a>' . ', ';
        }

        return rtrim($list, ', ');
    }

    /**
     * Retrieves a list of subjects of the painting
     */
    public function getSubjectsList(): string
    {
        $list = '';

        foreach ($this->model->subjects as $subject) {
            $list .= '<a href="' . Url::to(['/subject/default/view', 'id' => $subject->id]) . '">' . $subject->name . '</a>' . ', ';
        }

        return rtrim($list, ', ');
    }

    /**
     * Returns the start (if it exists) and end date of the painting as a string
     */
    public function getDateToDisplay(): string
    {
        $dates = '';

        if ($this->model->start_date) {
            $dates .= $this->model->start_date . ' — ';
        }

        return $dates . $this->model->end_date;
    }

    /**
     * Return string that contains title and dates info to display it
     */
    public function getNameToDisplay(): string
    {
        return $this->model->title . ' ' . $this->getDateToDisplay();
    }
}
