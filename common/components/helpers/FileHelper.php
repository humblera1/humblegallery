<?php

namespace common\components\helpers;

use yii\helpers\FileHelper as YiiFileHelper;

class FileHelper extends YiiFileHelper
{
    public static function unlinkIfExist(string $path): bool
    {
        if (!file_exists($path)) {
            return true;
        }

        return self::unlink($path);
    }
}
