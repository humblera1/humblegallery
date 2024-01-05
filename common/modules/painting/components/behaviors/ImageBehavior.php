<?php

namespace common\modules\painting\components\behaviors;

use common\modules\painting\models\data\Painting;
use yii\base\Behavior;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ImageBehavior extends Behavior
{
    public function saveImage(): bool
    {
        /** @var Painting $model */
        $model = $this->owner;

        $model->image = UploadedFile::getInstance($model, 'image');

        if (!$model->image) {
            return true;
        }

        $uploadPath = $this->getUploadPath();

        $imageName = $model->title . '.' . $model->image->extension;
        $imagePath = $uploadPath . '/' . $imageName;

        if ($model->image->saveAs($imagePath)) {
            $model->image_name = $imageName;

            return true;
        }

        return false;
    }

    public function getUploadPath(): string
    {
        return Url::to('@common/uploads/paintings');
    }
}