<?php

namespace common\components\behaviors;

use common\components\helpers\FileHelper;
use Yii;
use yii\base\Behavior;
use yii\base\Model;
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
     * @var string $directoryPath The directory path where the file will be saved.
     */
    public string $directoryPath = '@app/uploads/';

    /**
     * @var string|callable $fileName The pattern or callback for the file name.
     */
    public $fileName = '{slug}-{timestamp}.{extension}';

    /**
     * @var string|callable $removeOldFile Атрибут, сигнализирующий о необходимости удаления старого файла.
     */
    public $removeOldFile;

    /**
     * Handles the file upload process by assigning the uploaded file to the model attribute.
     */
    public function loadWithFile(array $dataToLoad): bool
    {
        /** @var Model $model */
        $model = $this->owner;
        $file = UploadedFile::getInstance($model, $this->fileAttribute);

        if ($file) {
            $model->{$this->fileAttribute} = $file;
        }

        return $model->load($dataToLoad);

    }

    /**
     * Saves the uploaded file to the specified directory and updates the model's file name attribute.
     *
     * @return bool Whether the file was successfully saved.
     */
    public function saveFile(): bool
    {
        /** @var Model $model */
        $model = $this->owner;
        $file = $model->{$this->fileAttribute};

        // Check if the old file should be removed
        if (($file || $this->shouldRemoveOldFile()) && !$this->removeCover()) {
            return false;
        }

        // If no new file is uploaded, return true after removing the old file
        if (!$file) {
            return true;
        }

        $fileName = $this->generateFileName($model, $file);

        $path = Url::to(Yii::getAlias($this->directoryPath));

        try {
            FileHelper::createDirectory($path);

            if ($file->saveAs($path . $fileName)) {
                $model->{$this->fileNameAttribute} = $fileName;

                // temp file $file->tempName no longer exists, it may cause the validation error
                $model->{$this->fileAttribute} = null;
                
                return true;
            }
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
        }

        return false;
    }

    /**
     * Generates a file name based on the specified pattern or callback.
     *
     * @param Model $model The model instance.
     * @param UploadedFile $file The uploaded file instance.
     * @return string The generated file name.
     */
    protected function generateFileName(Model $model, UploadedFile $file): string
    {
        if (is_callable($this->fileName)) {
            return call_user_func($this->fileName, $model, $file);
        }

        $replacements = [
            '{timestamp}' => time(),
            '{extension}' => $file->extension,
        ];

        // Dynamically replace attribute placeholders with model attribute values
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($model) {
            $attribute = $matches[1];
            return $model->{$attribute} ?? $matches[0];
        }, $this->fileName);

        return strtr($pattern, $replacements);
    }

    /**
     * Determines whether the old file should be removed.
     *
     * @return bool Whether the old file should be removed.
     */
    protected function shouldRemoveOldFile(): bool
    {
        if (is_callable($this->removeOldFile)) {
            return call_user_func($this->removeOldFile, $this->owner);
        }

        if (is_string($this->removeOldFile)) {
            return (bool)$this->owner->{$this->removeOldFile};
        }

        return false;
    }

    /**
     * Removes the old file from the directory.
     *
     * @return bool Whether the old file was successfully removed.
     */
    protected function removeCover(): bool
    {
        $coverName = $this->owner->{$this->fileNameAttribute};

        if (!$coverName) {
            return true;
        }

        $fileToDelete = Url::to(Yii::getAlias($this->directoryPath)) . $coverName;

        if (FileHelper::unlinkIfExist($fileToDelete)) {
            $this->owner->{$this->fileNameAttribute} = null;

            return true;
        }

        return false;
    }
}
