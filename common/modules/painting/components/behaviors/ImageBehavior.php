<?php

namespace common\modules\painting\components\behaviors;

use common\components\Image;
use common\modules\painting\models\data\Painting;
use Exception;
use yii\base\Behavior;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Url;

class ImageBehavior extends Behavior
{
    const TARGET_THUMBNAIL_FILESIZE = 50 * 1024; // 50 KB

    private ?string $folderName = null;

    public function saveImage()
    {
        /** @var Painting $model */
        $model = $this->owner;

        if (!$model->image) {
            return;
        }

        if ($model->getScenario() === Model::SCENARIO_DEFAULT) {
            $this->removeImage();
        }

        $this->folderName = $model->artist->name;

        $mainFolder = $this->getMainPath();

        $imageName = $model->title . '.' . $model->image->extension;
        $imagePath = $mainFolder . '/' . $imageName;

        FileHelper::createDirectory($mainFolder);

        if ($model->image->saveAs($imagePath) && $this->saveThumbnailImage($imagePath)) {
            $model->image_name = $imageName;

            return;
        }

        throw new Exception('Ошибка при сохранении изображения');
    }

    public function getImagePath(): string
    {
        return Url::to('@common/uploads/images/paintings/' . $this->folderName);
    }

    public function getThumbnailPath(): string
    {
        return Url::to('@common/uploads/thumbnails/paintings/' . $this->folderName);
    }

    public function saveThumbnailImage(string $mainImagePath): bool
    {
        $thumbnailFolder = $this->getMainPath();

        $thumbnailName = $this->owner->title . '.webp';
        $thumbnailPath = $thumbnailFolder . '/' . $thumbnailName;

        FileHelper::createDirectory($thumbnailPath);

        $image = new Image($mainImagePath);
        return $image->saveWebp($thumbnailPath, self::TARGET_THUMBNAIL_FILESIZE);
    }

    public function removeImage($deleteParentFolder = false): void
    {
        $mainFolder = $this->getMainPath();
        $thumbnailFolder = $this->getThumbnailPath();

        $imageToDelete = $mainFolder . '/' . $this->owner->image_name;
        $thumbnailToDelete = $thumbnailFolder . '/' . $this->owner->title . '.webp';

        if (file_exists($imageToDelete) && $isSuccess = FileHelper::unlink($imageToDelete)) {
            if ($deleteParentFolder && empty(FileHelper::findFiles($mainFolder))) {
                FileHelper::removeDirectory($mainFolder);
                FileHelper::removeDirectory($thumbnailFolder);
            }
        }

        if (file_exists($thumbnailToDelete) && $isSuccess) {
            $isSuccess = FileHelper::unlink($thumbnailToDelete);
        }

        if (!$isSuccess) {
            throw new Exception('Ошибка при удалении старого изображения');
        }
    }
}
