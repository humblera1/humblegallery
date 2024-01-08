<?php

namespace common\modules\painting\models\service;

use common\components\Service;
use yii\helpers\Url;

class PaintingService extends Service
{
    public function getImagePath(): string
    {
        return '/uploads/paintings/' . $this->model->image_name;
    }

    public function getThumbnail(): string
    {
        $model = $this->model;
        return '/uploads/thumbnails/paintings/' . $model->artist->name . '/' . $model->title . '.webp';
    }

    public function getMovementsList(): string
    {
        $list = '';

        foreach ($this->model->movements as $movement) {
            $list .= '<a href="' . Url::to(['/movement/default/view', 'id' => $movement->id]) . '">' . $movement->name . '</a>' . ', ';
        }

        return rtrim($list, ', ');
    }

    public function getSubjectsList(): string
    {
        $list = '';

        foreach ($this->model->subjects as $subject) {
            $list .= '<a href="' . Url::to(['/subject/default/view', 'id' => $subject->id]) . '">' . $subject->name . '</a>' . ', ';
        }

        return rtrim($list, ', ');
    }
}