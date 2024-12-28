<?php

namespace common\components\urls;

use common\components\interfaces\SelfHealingUrlHandlerInterface;

/**
 * Конфигурируемый класс
 */
class SelfHealingUrlHandler implements SelfHealingUrlHandlerInterface
{
    public function generateSelfHealingUrl(string $slugPart, int|string $uniquePart): string
    {
        return $slugPart . '-' . IdHashConverter::getHashById($uniquePart);
    }

    public function getUniquePartFromUrl(string $url): int|string
    {
        $parts = explode('-', $url);

        return IdHashConverter::getIdByHash(array_pop($parts));
    }

    public function getSlugPartFromUrl(string $url): string
    {
        $parts = explode('-', $url);
        array_pop($parts);

        return implode('-', $parts);
    }
}
