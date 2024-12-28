<?php

namespace common\components\interfaces;

/**
 * Объявляет методы для преобразования идентификатора в хэш и обратного преобразования хэша в идентификатор.
 */
interface IdHashConverterInterface
{
    public static function getHashById(int|string $id): string;

    public static function getIdByHash(string $hash): int|string;
}