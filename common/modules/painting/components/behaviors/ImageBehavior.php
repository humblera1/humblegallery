<?php

namespace common\modules\painting\components\behaviors;

use common\components\Thumb;
use common\modules\painting\models\data\Painting;
use Exception;
use yii\base\Behavior;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ImageBehavior extends Behavior
{
    const THUMBNAIL_IMAGE_QUALITY = 90;
    const THUMBNAIL_MAX_WIDTH = 500;
    const THUMBNAIL_MAX_HEIGHT = 500;

    public function saveImage(): bool
    {
        /** @var Painting $model */
        $model = $this->owner;

        $model->image = UploadedFile::getInstance($model, 'image');

        switch (true) {
            case ($model->isNewRecord && !$model->image):
                return false;
            case (!$model->isNewRecord && !$model->image):
                return true;
            case (!$model->isNewRecord && $model->image):
                unlink($this->getMainPath() . '/' . $model->image_name);
        }

        $uploadPath = $this->getMainPath();
        $imageExtension = $model->image->extension;
        $imageName = $model->title . '.' . $imageExtension;

        $imagePath = $uploadPath . '/' . $imageName;

        if ($model->image->saveAs($imagePath) && $this->saveThumbnailImage($imageName)) {
            $model->image_name = $imageName;

            return true;
        }

        return false;
    }

    public function getMainPath(): string
    {
        return Url::to('@common/uploads/images/paintings');
    }

    public function getThumbnailPath(): string
    {
        return Url::to('@common/uploads/thumbnails/paintings');
    }

    public function saveThumbnailImage(string $imageName): bool
    {
        $imagePath = $this->getMainPath() . '/' . $imageName;
        $thumbnailPath = $this->getThumbnailPath() . '/' . $this->owner->title . '.webp';

        try {
            $image = new Thumb($imagePath);
            $image->reduce(self::THUMBNAIL_MAX_WIDTH, self::THUMBNAIL_MAX_HEIGHT);

            return $image->saveWebp($thumbnailPath, self::THUMBNAIL_IMAGE_QUALITY);
        } catch (Exception) {

            //TODO: залогировать в sentry

            return false;
        }
    }
}
