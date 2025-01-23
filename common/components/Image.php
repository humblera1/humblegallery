<?php

namespace common\components;

use GdImage;
use InvalidArgumentException;
use RuntimeException;

class Image
{
    const IMAGE_GIF = 1;
    const IMAGE_JPEG = 2;
    const IMAGE_PNG = 3;
    const IMAGE_WEBP = 18;

    const INITIAL_IMAGE_QUALITY = 100;

    const QUALITY_REDUCING_STEP = 5;

    public ?int $size = null;

    public ?int $type = null;

    public ?GdImage $img = null;

    public function __construct(public string $sourcePath)
    {
        if (!isset($this->sourcePath)) {
            throw new InvalidArgumentException('Необходимо указать корректное имя файла');
        }

        if (!file_exists($this->sourcePath)) {
            throw new InvalidArgumentException(sprintf('Файл %s не найден', $this->sourcePath));
        }

        $imageInfo = getimagesize($this->sourcePath);

        if ($imageInfo === false) {
            throw new RuntimeException('Не удалось получить информацию о файле');
        }

        $this->size = filesize($this->sourcePath);
        $this->type = $imageInfo[2];

        $this->img = match($this->type) {
            self::IMAGE_GIF => imagecreatefromgif($this->sourcePath),
            self::IMAGE_JPEG => imagecreatefromjpeg($this->sourcePath),
            self::IMAGE_PNG => imagecreatefrompng($this->sourcePath),
            self::IMAGE_WEBP => imagecreatefromwebp($this->sourcePath),

            default => throw new InvalidArgumentException('Неподдерживаемый формат изображения'),
        };
    }

    public function saveWebp(string $destinationPath, ?int $targetFileSize = null): bool
    {
        return $this->saveWithQualityAdjustment($destinationPath, $targetFileSize, 'imagewebp');
    }

    public function savePng(string $destinationPath, ?int $targetFileSize = null): bool
    {
        return $this->saveWithQualityAdjustment($destinationPath, $targetFileSize, 'imagepng');
    }

    public function saveJpeg(string $destinationPath, ?int $targetFileSize = null): bool
    {
        return $this->saveWithQualityAdjustment($destinationPath, $targetFileSize, 'imagejpeg');
    }

    public function saveGif(string $filename): bool
    {
        return imagegif($this->img, $filename);
    }

    // todo: deprecated
    public function saveImage(string $fileName): bool
    {
        return match ($this->type) {
            self::IMAGE_GIF => $this->saveGif($fileName),
            self::IMAGE_JPEG => $this->saveJpeg($fileName),
            self::IMAGE_PNG => $this->savePng($fileName),
            self::IMAGE_WEBP => $this->saveWebp($fileName),
        };
    }

    public function getExtensionAsString(): string
    {
        return image_type_to_extension($this->type);
    }

    public function saveAs(string $destinationPath, string $extension, ?int $targetFileSize = null): bool
    {
        return match($extension) {
            'webp' => $this->saveWebp($destinationPath, $targetFileSize),
            'jpg', 'jpeg' => $this->saveJpeg($destinationPath, $targetFileSize),
            'png' => $this->savePng($destinationPath, $targetFileSize),

            default => false,
        };
    }

    private function saveWithQualityAdjustment(string $destinationPath, ?int $targetFileSize, callable $saveFunction): bool
    {
        if (!$targetFileSize || $targetFileSize > $this->size) {
            return $saveFunction($this->img, $destinationPath, self::INITIAL_IMAGE_QUALITY);
        }

        $initialQuality = self::INITIAL_IMAGE_QUALITY;
        $step = self::QUALITY_REDUCING_STEP;

        while ($initialQuality > 10) {
            ob_start();

            $saveFunction($this->img, null, $initialQuality);
            $imageData = ob_get_clean();

            if ($targetFileSize >= strlen($imageData)) {
                break;
            }

            $initialQuality -= $step;
        }

        return $saveFunction($this->img, $destinationPath, $initialQuality);
    }
}
