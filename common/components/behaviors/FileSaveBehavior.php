<?php

namespace common\components\behaviors;

use common\components\helpers\FileHelper;
use common\components\Image;
use Yii;
use yii\base\Behavior;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * FileSaveBehavior manages the process of saving files to a specified directory, generating file names, and removing old files when necessary
 * To use `FileSaveBehavior`, attach it to your ActiveRecord class as follows:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'fileSave' => [
 *             'class' => FileSaveBehavior::class,
 *             'fileAttribute' => 'file', // The attribute for the file input
 *             'fileNameAttribute' => 'filename', // The attribute to store the file name
 *              'directoryPath' => 'app/uploads/', // Directory path for saving files
 *              'fileName' => '{slug}-{timestamp}.{extension}', // Pattern for file name
 *              'removeOldFile' => function($model) {
 *                  return $model->isAttributeChanged('file');
 *               },
 *         ],
 *     ];
 * }
 * ```
 */
class FileSaveBehavior extends Behavior
{
    /**
     * @var string $fileAttribute The attribute name for the file input.
     */
    public string $fileAttribute = 'file';

    /**
     * @var string $fileNameAttribute The attribute that stores the file name.
     */
    public string $fileNameAttribute = 'filename';

    /**
     * @var bool $withThumbnail Whether to generate a thumbnail for the uploaded file.
     */
    public bool $withThumbnail = false;

    /**
     * @var string $directoryPath The directory path where the file will be saved.
     */
    public string $directoryPath = '@app/uploads/';

    /**
     * @var string $thumbnailDirectoryPath The directory path where the thumbnail will be saved.
     */
    public string $thumbnailDirectoryPath = '@app/uploads/thumbnails/';

    /**
     * @var string|callable $fileName The pattern or callback for the file name.
     */
    public $fileName = '{slug}-{timestamp}.{extension}';

    /**
     * @var string[]|callable $watch Атрибуты или колбэк, сигнализирующий о необходимости переименования файла.
     */
    public $updateWhen;

    /**
     * @var string|callable $removeOldFile Атрибут или колбэк, сигнализирующий о необходимости удаления старого файла.
     */
    public $removeWhen;

    public bool $removeOldFile = true;

    public ?string $targetExtension = null;

    public ?int $targetSize = null;

    public ?int $targetThumbnailSize = null;

    private $tempFilePath;

//    protected $image;

    public function events(): array
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'handleFileUpload',

            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',

            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',

            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function handleFileUpload(): void
    {
        /** @var Model $model */
        $model = $this->owner;
        $file = UploadedFile::getInstance($model, $this->fileAttribute);

        if ($file) {
            $model->{$this->fileAttribute} = $file;

            if (!isset($this->targetExtension)) {
                $this->targetExtension = $file->extension;
            }
        }
    }

    public function beforeSave(): bool
    {
        $model = $this->owner;
        $file = $model->{$this->fileAttribute};

        // If no new file is uploaded, return result of removing/renaming the existing file
        if (!$file) {
            return $this->runWatchers();
        }

        if (!$this->checkDir()) {
            $model->addError($this->fileAttribute, 'Provided directory is not writable: ' . $this->directoryPath);

            return false;
        }

        if ($this->withThumbnail && !$this->checkThumbnailDir()) {
            $model->addError($this->fileAttribute, 'Provided directory for thumbnails is not writable: ' . $this->thumbnailDirectoryPath);

            return false;
        }

        // remove old file
        if ($this->removeOldFile && !$this->removeFile()) {
            $model->addError($this->fileAttribute, 'Failed to remove old file.');

            return false;
        }

        $this->tempFilePath = $this->saveTempFile($file);

        if (!$this->tempFilePath) {
            $model->addError($this->fileAttribute, 'Failed to save file temporarily.');

            return false;
        }

        return true;
    }

    public function afterSave(): void
    {
        $model = $this->owner;
        $file = $model->{$this->fileAttribute};

        if ($file && $this->tempFilePath) {
            $image = new Image($this->tempFilePath);

            $fileName = $this->generateFileName();
            $path = Url::to(Yii::getAlias($this->directoryPath));

            try {
                if (!$image->saveAs($path . $fileName, 'webp', $this->targetSize)) {
                    throw new \Exception('Failed to save image to the specified location.');
                }

                if ($this->withThumbnail) {
                    $thumbnailPath = Url::to(Yii::getAlias($this->thumbnailDirectoryPath));

                    if (!$image->saveAs($thumbnailPath . $fileName, 'webp', $this->targetThumbnailSize)) {
                        throw new \Exception('Failed to save thumbnail image to the specified location.');
                    }
                }

                if (file_exists($this->tempFilePath)) {
                    unlink($this->tempFilePath);
                }

                $model->updateAttributes([$this->fileNameAttribute => $fileName]);
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
            }
        }
    }

    public function afterDelete(): void
    {
        $this->removeFile();
    }

    /**
     * Generates a file name based on the specified pattern or callback.
     *
     * @return string The generated file name.
     */
    protected function generateFileName(?string $extension = null): string
    {
        $model = $this->owner;
        $file = $model->{$this->fileAttribute};

        if (is_callable($this->fileName)) {
            return call_user_func($this->fileName, $model, $file);
        }

        $replacements = [
            '{timestamp}' => time(),
            '{extension}' => $extension ?? $this->targetExtension,
        ];

        // Dynamically replace attribute placeholders with model attribute values
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($model) {
            $attribute = $matches[1];
            return $model->{$attribute} ?? $matches[0];
        }, $this->fileName);

        return strtr($pattern, $replacements);
    }

    /**
     * Removes the old file from the directory.
     *
     * @return bool Whether the old file was successfully removed.
     */
    protected function removeFile(): bool
    {
        $name = $this->owner->{$this->fileNameAttribute};

        if (!$name) {
            return true;
        }

        $fileToDelete = Url::to(Yii::getAlias($this->directoryPath)) . $name;
        $thumbnailToDelete = Url::to(Yii::getAlias($this->thumbnailDirectoryPath)) . $name;

        if (FileHelper::unlinkIfExist($fileToDelete) && FileHelper::unlinkIfExist($thumbnailToDelete)) {
            $this->owner->{$this->fileNameAttribute} = null;

            return true;
        }

        return false;
    }

    protected function checkDir(): bool
    {
        $path = Yii::getAlias($this->directoryPath);

        if (!is_dir($path)) {
            try {
                FileHelper::createDirectory($path);
            } catch (\Exception $e) {
                return false;
            }
        }

        return is_writable($path);
    }

    protected function checkThumbnailDir(): bool
    {
        $path = Yii::getAlias($this->thumbnailDirectoryPath);

        if (!is_dir($path)) {
            try {
                FileHelper::createDirectory($path);
            } catch (\Exception $e) {
                return false;
            }
        }

        return is_writable($path);
    }

    protected function saveTempFile(UploadedFile $file): ?string
    {
        $tempDir = sys_get_temp_dir();
        $tempFilePath = tempnam($tempDir, 'upload_') . '.' . $file->extension;

        if ($file->saveAs($tempFilePath)) {
            return $tempFilePath;
        }

        return null;
    }

    protected function runWatchers(): bool
    {
        $model = $this->owner;

        if ($this->needToRemove() && !$this->removeFile()) {
            $model->addError($this->fileAttribute, 'Failed to delete old file.');

            return false;
        }

        if ($this->needToUpdate() && !$this->updateFile()) {
            $model->addError($this->fileAttribute, 'Failed to save new file name.');

            return false;
        }

        return false;
    }

    protected function needToRemove(): bool
    {
        if (is_callable($this->removeWhen)) {
            return call_user_func($this->removeWhen, $this->owner);
        }

        if (is_string($this->removeWhen) || is_array($this->removeWhen)) {
            return (bool)$this->owner->{$this->removeWhen};
        }

        return false;
    }

    protected function needToUpdate(): bool
    {
        if (is_callable($this->updateWhen)) {
            return call_user_func($this->updateWhen, $this->owner);
        }

        if (is_string($this->updateWhen)) {
            $this->updateWhen = [$this->updateWhen];
        }

        if (is_array($this->updateWhen)) {
            foreach ($this->updateWhen as $attribute) {
                if ($this->owner->isAttributeChanged($attribute)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function updateFile(): bool
    {
        $model = $this->owner;
        $oldFileName = $model->getOldAttribute($this->fileNameAttribute);

        $path = Yii::getAlias($this->directoryPath);
        $thumbnailPath = Yii::getAlias($this->thumbnailDirectoryPath);

        if (!$oldFileName || !file_exists($path . $oldFileName)) {
            return true;
        }

        $newFileName = $this->generateFileName(pathinfo($oldFileName)['extension']);

        if (rename($path . $oldFileName, $path . $newFileName)) {
            if ($this->withThumbnail && !rename($thumbnailPath . $oldFileName, $thumbnailPath . $newFileName)) {
                return false;
            }

            $model->updateAttributes([$this->fileNameAttribute => $newFileName]);

            return true;
        }

        return false;
    }
}
