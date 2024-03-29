<?php

namespace common\components;

use Exception;
use GdImage;

class Image
{
    const IMAGE_GIF = 1;
    const IMAGE_JPEG = 2;
    const IMAGE_PNG = 3;
    const IMAGE_WEBP = 18;

    const INITIAL_IMAGE_QUALITY = 90;

    public ?int $type = null;

    public ?GdImage $img = null;

    public function __construct(public string $filename)
    {
        if (!isset($this->filename)) {
            throw new Exception('Необходимо указать корректное имя файла');
        }

        if (!file_exists($this->filename)) {
            throw new Exception(sprintf('Файл %s не найден', $this->filename));
        }

        $this->type = getimagesize($this->filename)[2];

        $this->img = match($this->type) {
            self::IMAGE_GIF => imageCreateFromGif($this->filename),
            self::IMAGE_JPEG => imageCreateFromJpeg($this->filename),
            self::IMAGE_PNG => imageCreateFromPng($this->filename),
            self::IMAGE_WEBP => imageCreatefromWebp($this->filename),
            default => throw new Exception('Неподдерживаемый формат изображения'),
        };
    }

    public function saveWebp(string $filename, ?int $targetFileSize = null): bool
    {
        if (!$targetFileSize) {
            return imageWebp($this->img, $filename, 100);
        }

        $initialQuality = self::INITIAL_IMAGE_QUALITY;

        while ($initialQuality > 10) {
            ob_start();
            imagewebp($this->img, null, $initialQuality);

            if ($targetFileSize >= strlen(ob_get_clean())) {
                break;
            }

            $initialQuality -= 5;
        }

        return imageWebp($this->img, $filename, $initialQuality);
    }

    public function savePng(string $fileName): bool
    {
        return imagepng($this->img, $fileName);
    }

    public function saveJpeg(string $fileName): bool
    {
        return imagejpeg($this->img, $fileName);
    }

    public function saveGif(string $filename): bool
    {
        return imagegif($this->img, $filename);
    }

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
}
