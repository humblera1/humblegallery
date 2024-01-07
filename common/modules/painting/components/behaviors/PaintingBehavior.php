<?php

namespace common\modules\painting\components\behaviors;

use common\components\Image;
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
        /** @var Painting $model */
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
        /** @var Painting $model */
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
        /** @var Painting $model */
        $model = $this->owner;

        if (!$model->image) {
            return;
        }

        if ($model->getScenario() === Model::SCENARIO_DEFAULT) {
            $this->removeImage();
        }

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
     * @throws Exception If there is an error deleting the image or thumbnail
     */
    public function removeImage(bool $deleteParentFolder = false): void
    {
        $isSuccess = true;
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

    /**
     * Constructs the path to directory where main image will be saved
     *
     * For each author, a directory of the same name is created to contain all his works
     */
    public function getMainPath(): string
    {
        return Url::to('@common/uploads/images/paintings/' . $this->owner->artist->name);
    }

    /**
     * Constructs the path to directory where thumbnail image will be saved
     */
    public function getThumbnailPath(): string
    {
        return Url::to('@common/uploads/thumbnails/paintings/' . $this->owner->artist->name);
    }
}
