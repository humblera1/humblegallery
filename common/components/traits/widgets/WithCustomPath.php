<?php

namespace common\components\traits\widgets;

use ReflectionClass;

trait WithCustomPath
{
    public function getViewPath(): string
    {
        $class = new ReflectionClass(static::class);

        return dirname($class->getFileName()) .
            DIRECTORY_SEPARATOR .
            'views' .
            DIRECTORY_SEPARATOR .
            $class->getShortName();
    }
}