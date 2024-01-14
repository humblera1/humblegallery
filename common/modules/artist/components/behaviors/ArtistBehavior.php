<?php

namespace common\modules\artist\components\behaviors;

use common\components\enums\WarningCategoriesEnum;
use common\components\Image;
use common\modules\artist\models\data\Artist;
use Exception;
use Yii;
use yii\base\Behavior;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * This behavior is responsible for saving images and thumbnails associated with this model
 *
 * @property Artist $owner
 */
class ArtistBehavior extends Behavior
{
    const TARGET_THUMBNAIL_FILESIZE = 50 * 1024; // 50 KB

    /** {@inheritDoc} */
    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',

            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeSave(ModelEvent $event): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->saveImage();
        } catch (Exception $e) {
            Yii::warning($e->getMessage(), WarningCategoriesEnum::CATEGORY_ARTIST->value);
            Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении художника'));

            $transaction->rollBack();

            $event->isValid = false;

            return;
        }

        $transaction->commit();
    }

    /**
     * This methode handle 'beforeDelete' event
     *
     * It tries to remove an images, associated with this painting (and parent directory in case, if it no longer contains other images).
     * If an exception is caught, it logs a warning message, sets a flash message, rolls back the transaction,
     * and invalidates the delete event
     */
    public function beforeDelete(ModelEvent $event): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->removeImage();
        } catch(Exception $e) {
            Yii::warning($e->getMessage(), WarningCategoriesEnum::CATEGORY_ARTIST->value);
            Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при удалении художника'));

            $transaction->rollBack();

            $event->isValid = false;
        }

        $transaction->commit();
    }

    /**
     * Saves the image associated with the Artist model
     *
     * @throws Exception if there is an error while saving the image
     */
    public function saveImage(): void
    {
        $model = $this->owner;

        if (!$model->image) {
            return;
        }

        if ($model->getScenario() === Model::SCENARIO_DEFAULT) {
            $this->removeImage();
        }

        $mainFolder = $this->getMainPath();

        $imageName = $model->name . '.' . $model->image->extension;
        $imagePath = $mainFolder . '/' . $imageName;

        if ($model->image->saveAs($imagePath) && $this->saveThumbnailImage($imagePath)) {
            $model->image_name = $imageName;

            return;
        }

        throw new Exception('Ошибка при сохранении изображения');
    }

    /**
     * Saves a thumbnail image based on the given main image path
     *
     * Thumbnails are always saved with the webp extension, class constant defined the target file size
     *
     * @throws Exception If there is an error saving the thumbnail image
     */
    public function saveThumbnailImage(string $mainImagePath): bool
    {
        $thumbnailFolder = $this->getThumbnailPath();

        $thumbnailName = $this->owner->name . '.webp';
        $thumbnailPath = $thumbnailFolder . '/' . $thumbnailName;

        $image = new Image($mainImagePath);
        return $image->saveWebp($thumbnailPath, self::TARGET_THUMBNAIL_FILESIZE);
    }

    /**
     * Remove an image
     *
     * @throws Exception If there is an error deleting folder, image or thumbnail
     */
    public function removeImage(): void
    {
        $isSuccess = true;
        $owner = $this->owner;

        $mainFolder = $this->getMainPath();
        $thumbnailFolder = $this->getThumbnailPath();
        $artistName = $owner->getOldAttribute('name');

        $imageToDelete = $mainFolder . '/' . $owner->image_name;
        $thumbnailToDelete = $thumbnailFolder . '/' . $artistName . '.webp';

        if (file_exists($imageToDelete)) {
            $isSuccess = FileHelper::unlink($imageToDelete);
        }

        if (file_exists($thumbnailToDelete) && $isSuccess) {
            $isSuccess = FileHelper::unlink($thumbnailToDelete);
        }

        if (!$isSuccess) {
            throw new Exception('Ошибка при удалении старого изображения');
        }
    }

    /**
     * Constructs the path to directory where main image will be saved
     */
    public function getMainPath(): string
    {
        return Url::to('@common/uploads/images/artists');
    }

    /**
     * Constructs the path to directory where thumbnail image will be saved
     */
    public function getThumbnailPath(): string
    {
        return Url::to('@common/uploads/thumbnails/artists');
    }

}