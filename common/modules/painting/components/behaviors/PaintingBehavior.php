<?php

namespace common\modules\painting\components\behaviors;

use common\components\Image;
use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\data\Painting;
use common\modules\subject\models\data\Subject;
use Exception;
use Yii;
use yii\base\Behavior;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * This behavior is responsible for saving new movements and subjects associated with this model,
 * image and its thumbnail
 *
 * @property Painting $owner
 */

class PaintingBehavior extends Behavior
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

    /**
     * This methode handle 'beforeInsert' and 'beforeUpdate' events
     *
     * It tries to save new movements and subjects, and an image
     *
     * If an exception is caught during any of these tasks, it logs a warning message, sets a flash message to inform
     * user about error occurring, rolls back the transaction, and invalidates event
     */
    public function beforeSave(ModelEvent $event): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->saveMovements();
            $this->saveSubjects();
            $this->saveImage();
        } catch (Exception $e) {
            Yii::warning($e->getMessage(), 'painting');
            Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при сохранении картины'));

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
            $this->removeImage(true);
        } catch(Exception $e) {
            Yii::warning($e->getMessage(), 'painting');
            Yii::$app->session->setFlash('error', Yii::t('app', 'Произошла ошибка при удалении картины'));

            $transaction->rollBack();

            $event->isValid = false;
        }

        $transaction->commit();
    }

    /**
     * Saves the new movements associated with the painting model
     *
     * @throws Exception if there is an error saving new Movement model
     */
    public function saveMovements(): void
    {
        $model = $this->owner;
        $newIds = [];

        foreach ($model->movementIds as $movementToSave) {
            if (!Movement::findOne($movementToSave)) {
                $movement = new Movement();
                $movement->name = $movementToSave;

                if ($movement->save()) {
                    $newIds[] = $movement->id;

                    continue;
                }

                throw new Exception('Ошибка при сохранении направления');
            }

            $newIds[] = $movementToSave;
        }

        $model->movementIds = $newIds;
    }

    /**
     * Saves the new subjects associated with the painting model
     *
     * @throws Exception if there is an error saving new Subject model
     */
    public function saveSubjects(): void
    {
        $model = $this->owner;
        $newIds = [];

        foreach ($model->subjectIds as $subjectToSave) {
            if (!Subject::findOne($subjectToSave)) {
                $subject = new Subject();
                $subject->name = $subjectToSave;

                if ($subject->save()) {
                    $newIds[] = $subject->id;

                    continue;
                }

                throw new Exception('Ошибка при сохранении жанра');
            }

            $newIds[] = $subjectToSave;
        }

        $model->subjectIds = $newIds;
    }

    /**
     * Saves the image associated with the Painting model
     *
     * @throws Exception if there is an error while saving the image
     */
    public function saveImage(): void
    {
        $model = $this->owner;
        $dirtyAttributes = $model->getDirtyAttributes(['artist_id', 'title']);

        if (!$model->image && !$dirtyAttributes) {
            return;
        }

        switch (true) {
            case (isset($dirtyAttributes['artist_id'])):
                $this->onArtistUpdate();
                break;
            case (isset($dirtyAttributes['title'])):
                $this->onTitleUpdate();
                break;
            default:
                $this->removeImage();
                $this->saveUploadedFile();
        }
    }

    /**
     * Called if the artist of this painting (or both the artist and the title) has been changed.
     *
     * If a new image has not been uploaded, this method will determine the previous location of the main
     * image and thumbnail, based on the model's _oldAttributes values, will save them to new directories and delete them
     * from the old ones.
     *
     * If a new image has been uploaded, the function will simply remove main image and thumbnail from the irrelevant directory,
     * and call the saveUploadedFile() method to save the new image
     *
     * @throws Exception if there is an error while moving/saving images
     */
    public function onArtistUpdate(): void
    {
        $model = $this->owner;

        if (!$model->image) {
            $previousTitle = $model->getOldAttribute('title');
            $previousArtistName = $this->getPreviousArtistName();

            $previousMainImagePath = $this->getMainPath($previousArtistName) . '/' . $model->image_name;
            $previousThumbnailPath = $this->getThumbnailPath($previousArtistName) . '/' . $previousTitle . '.webp';

            $image = new Image($previousMainImagePath);
            $thumbnail = new Image($previousThumbnailPath);

            $mainFolder = $this->getMainPath();
            $thumbnailFolder = $this->getThumbnailPath();

            FileHelper::createDirectory($mainFolder);
            FileHelper::createDirectory($thumbnailFolder);

            $newImageName = $model->title . $image->getExtensionAsString();
            $newMainImagePath = $mainFolder . '/' . $newImageName;
            $newThumbnailPath = $thumbnailFolder . '/' . $model->title . '.webp';

            if ($image->saveImage($newMainImagePath) && $thumbnail->saveWebp($newThumbnailPath, self::TARGET_THUMBNAIL_FILESIZE)) {
                $this->removeImage(true);

                $model->image_name = $newImageName;

                return;
            }

            throw new Exception('Ошибка при перемещении изображения');
        }

        $this->removeImage(true);
        $this->saveUploadedFile();
    }

    /**
     * Called if the title of this painting has been updated.
     *
     * If a new image has not been uploaded, this method will rename the existing image and thumbnail.
     *
     * Otherwise, method remove main image and thumbnail, and call the saveUploadedFile() method to save the new image
     *
     * @throws Exception if there is an error while renaming/saving images
     */
    public function onTitleUpdate(): void
    {
        $model = $this->owner;
        $previousTitle = $model->getOldAttribute('title');

        if (!$model->image) {
            $previousMainImagePath = $this->getMainPath() . '/' . $model->image_name;
            $previousThumbnailPath = $this->getThumbnailPath() . '/' . $previousTitle . '.webp';

            $image = new Image($previousMainImagePath);

            $newImageName = $model->title . '.' . $image->getExtensionAsString();

            $newMainImagePath = $this->getMainPath() . '/' . $newImageName;
            $newThumbnailPath = $this->getThumbnailPath() . '/' . $model->title .'.webp';

            if (rename($previousMainImagePath, $newMainImagePath) && rename($previousThumbnailPath, $newThumbnailPath)) {

                $model->image_name = $newImageName;

                return;
            }

            throw new Exception('Ошибка при переименовании изображения');
        }

        $this->removeImage();
        $this->saveUploadedFile();
    }

    /**
     * Saves the uploaded file.
     *
     * @throws Exception if there is an error while saving the uploaded image
     */
    public function saveUploadedFile(): void
    {
        $model = $this->owner;
        $mainFolder = $this->getMainPath();

        $imageName = $model->title . '.' . $model->image->extension;
        $imagePath = $mainFolder . '/' . $imageName;

        FileHelper::createDirectory($mainFolder);

        if ($model->image->saveAs($imagePath) && $this->saveThumbnailImage($imagePath)) {
            $model->image_name = $imageName;

            return;
        }

        throw new Exception('Ошибка при сохранении загруженного изображения');
    }

    /**
     * Saves a thumbnail image based on the given main image path
     *
     * Thumbnails are always saved with the webp extension, class constant defined the target file size
     *
     * @throws Exception If there is an error creating the thumbnail directory or saving the thumbnail image
     */
    public function saveThumbnailImage(string $mainImagePath): bool
    {
        $thumbnailFolder = $this->getThumbnailPath();

        $thumbnailName = $this->owner->title . '.webp';
        $thumbnailPath = $thumbnailFolder . '/' . $thumbnailName;

        FileHelper::createDirectory($thumbnailFolder);

        $image = new Image($mainImagePath);
        return $image->saveWebp($thumbnailPath, self::TARGET_THUMBNAIL_FILESIZE);
    }

    /**
     * Remove an image and its associated thumbnail
     *
     * @param bool $deleteParentFolder Whether to delete the parent folder if it's empty
     * @throws Exception If there is an error deleting folder, image or thumbnail
     */
    public function removeImage(bool $deleteParentFolder = false): void
    {
        $isSuccess = true;
        $owner = $this->owner;

        $artistName = $this->getPreviousArtistName();

        $mainFolder = $this->getMainPath($artistName);
        $thumbnailFolder = $this->getThumbnailPath($artistName);

        $imageToDelete = $mainFolder . '/' . $owner->image_name;
        $thumbnailToDelete = $thumbnailFolder . '/' . $owner->getOldAttribute('title') . '.webp';

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

    /**
     * Constructs the path to directory where main image will be saved
     *
     * For each author, a directory of the same name is created to contain all his works
     */
    public function getMainPath(string $artistName = null): string
    {
        $folderName = $artistName ?? $this->owner->artist->name;

        return Url::to('@common/uploads/images/paintings/' . $folderName);
    }

    /**
     * Constructs the path to directory where thumbnail image will be saved
     */
    public function getThumbnailPath(string $artistName = null): string
    {
        $folderName = $artistName ?? $this->owner->artist->name;

        return Url::to('@common/uploads/thumbnails/paintings/' . $folderName);
    }

    /**
     * Returns the name of the previous artist
     */
    public function getPreviousArtistName(): string
    {
        return Artist::find()
            ->select('name')
            ->where(['id' => $this->owner->getOldAttribute('artist_id')])
            ->scalar();
    }
}
