<?php

namespace common\modules\user\models\enums;

enum ProfileSectionsEnum: string
{
    case SECTION_INFO = 'info';
    case SECTION_COLLECTIONS = 'collections';
    case SECTION_COURSES = 'courses';
    case SECTION_FAVORITES = 'favorites';
    case SECTION_SETTINGS = 'settings';

    public static function getLabels(): array
    {
        return [
            self::SECTION_INFO->value,
            self::SECTION_COLLECTIONS->value,
            self::SECTION_COURSES->value,
            self::SECTION_FAVORITES->value,
            self::SECTION_SETTINGS->value,
        ];
    }
}
