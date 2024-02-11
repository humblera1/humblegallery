<?php

namespace frontend\components\widgets;

use frontend\assets\ProfileNavbarBundle;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProfileNavbar extends Widget
{
    public array $items = [];

    public string $iconDefault = 'circle';

    public string $itemTemplate = '<li class="navigation__li {active}" data-section-name="{section}">{content}</li>';
    public string $linkTemplate = '<div class="navigation__link">{icon} {label}</div>';

    /** {@inheritdoc} */
    public function init(): void
    {
        //
    }

    /** {@inheritdoc} */
    public function run(): string
    {
//        $this->registerAssets();
        return Html::tag('ul', $this->renderItems($this->items));
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
        $template = ArrayHelper::getValue($item, 'template', $this->itemTemplate);

        $iconClass = 'navigation__icon fa-solid fa-' . ArrayHelper::getValue($item, 'icon', $this->iconDefault);

        $content = strtr($this->linkTemplate, [
            '{icon}' => Html::tag('i', '', ['class' => $iconClass]),
            '{label}' => '<span>' . Html::encode($item['label']) . '</span>',
        ]);

        return strtr($template, [
            '{active}' => isset($item['active']) ? 'navigation__li_active' : '',
            '{content}' => $content,
            '{section}' => ArrayHelper::getValue($item, 'section', ''),
        ]);
    }

//    public function registerAssets(): void
//    {
//        ProfileNavbarBundle::register($this->getView());
//    }
}