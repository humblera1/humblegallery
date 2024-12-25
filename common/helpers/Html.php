<?php

namespace common\helpers;

use Yii;
use yii\helpers\BaseHtml;

class Html extends BaseHtml
{
    const ICON_DIR = '@webroot/svg/';

    /**
     * Вывод SVG-файла из директории web/svg
     *
     * @param string $filename Имя файла SVG
     * @return string
     */
    public static function icon(string $filename): string
    {
        $path = Yii::getAlias(self::ICON_DIR . $filename . '.svg');

        if (!file_exists($path)) {
            return '';
        }

        return file_get_contents($path);
    }
}