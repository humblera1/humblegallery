<?php

namespace common\components\urls;

use common\components\interfaces\IdHashConverterInterface;
use Hashids\Hashids;

class IdHashConverter implements IdHashConverterInterface
{
    private static ?Hashids $hashids = null;

    private static string $secretKey = 'The Sleep of Reason Produces Monsters';

    public static function getHashById(int|string $id): string
    {
        return self::getHashids()->encode($id);
    }

    public static function getIdByHash(string $hash): int|string
    {
        $ids = self::getHashids()->decode($hash);

        if (empty($ids)) {
            return '';
        }

        return $ids[0];
    }

    protected static function getHashids(): Hashids
    {
        if (self::$hashids === null) {
            self::$hashids = new Hashids(self::$secretKey, 8);
        }

        return self::$hashids;
    }
}
