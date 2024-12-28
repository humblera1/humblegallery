<?php

namespace common\components\interfaces;

interface SelfHealingUrlHandlerInterface
{
    public function generateSelfHealingUrl(string $slugPart, int|string $uniquePart): string;

    public function getUniquePartFromUrl(string $url): int|string;

    public function getSlugPartFromUrl(string $url): string;
}