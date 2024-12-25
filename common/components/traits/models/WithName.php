<?php

namespace common\components\traits\models;

use Yii;
use yii\helpers\Inflector;

trait WithName
{
    /**
     * Возвращает удобочитаемое имя модели.
     *
     * @return string
     */
    public static function displayLabel(): string
    {
        return Yii::t('app', self::getName());
    }

    /**
     * Возвращает множественное удобочитаемое имя модели.
     *
     * @return string
     */
    public static function displayPluralLabel(): string
    {
        return Yii::t('app', self::getPluralName());
    }

    /**
     * Возвращает имя таблицы модели.
     *
     * @return string
     */
    public static function getName(): string
    {
        return self::tableName();
    }

    /**
     * Возвращает множественное имя таблицы модели.
     *
     * @return string
     */
    public static function getPluralName(): string
    {
        return Inflector::pluralize(self::tableName());
    }
}