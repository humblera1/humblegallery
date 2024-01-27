<?php

namespace frontend\components\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProfileNavbar extends Widget
{
    public array $items = [];

    public string $iconDefault = 'circle';

    public string $itemTemplate = '<li class="navigation__li">{content}</li>';
    public string $linkTemplate = '<a class="navigation__link" href="{url}">{icon} {label}</a>';

    /** {@inheritdoc} */
    public function init(): void
    {
        //
    }

    /** {@inheritdoc} */
    public function run(): void
    {
        echo Html::tag('ul', $this->renderItems($this->items));
    }

    public function renderItems(): string
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }

        return implode("\n", $items);
    }

    public function renderItem(array $item): string
    {
        $template = $this->generateTemplate();

        $iconClass = 'nav-icon fa-solid fa-' . ArrayHelper::getValue($item, 'icon', $this->iconDefault);
        $itemIcon = Html::tag('i', '', ['class' => $iconClass]);



        return '';
    }


}