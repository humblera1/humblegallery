<?php

namespace common\components\widgets;

class FilterSection
{
    public function __construct(
        /**
         * @var string $attribute Атрибут для формирования фильтров секции.
         */
        public string $attribute,

        /**
         * @var array $items Элементы секции.
         */
        public array $items,

        /**
         * @var bool $multiple Множественный выбор.
         */
        public bool $multiple = false,

        /**
         * @var mixed|null $selected Выбранный элемент.
         */
        public mixed $selected = null,
    ) {}
}
