<?php

namespace common\widgets;

use common\helpers\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class ProfileNavWidget extends Widget
{
    public array $items = [
        [
            'label' => 'Профиль',
            'url' => '/user/default/view',
        ],
        [
            'label' => 'Коллекции',
            'url' => '/user/default/collections',
        ],
        [
            'label' => 'Избранное',
            'url' => '/user/default/favorites',
        ],
        [
            'label' => 'Настройки',
            'url' => '/user/default/settings',
        ],
        [
            'label' => 'Выход',
            'url' => 'auth/logout',
        ],
    ];

    public function run()
    {
        return Html::tag('ul', $this->renderItems(), ['class' => 'profile-nav']);
    }

    protected function renderItems(): string
    {
        $itemsHtml = '';

        foreach ($this->items as $item) {
            $itemsHtml .= $this->renderItem($item);
        }

        return $itemsHtml;
    }

    protected function renderItem(array $item): string
    {
        $label = $item['label'];
        $url = $item['url'];

        $isActive = $this->isItemActive($item) ? 'profile-nav__item_active' : '';

        return Html::tag('li', $this->renderItemContent($label, $url), ['class' => "profile-nav__item $isActive"]);
    }

    protected function renderItemContent(string $itemLabel, string $itemUrl): string
    {
        $itemContent = Html::tag('div', Html::icon($this->getIconName($itemLabel)), ['class' => 'profile-nav__icon']);
        $itemContent .= Html::tag('p', $itemLabel, ['class' => 'profile-nav__label']);

        return Html::a($itemContent, [$itemUrl, 'username' => Yii::$app->user->identity->username], ['class' => 'profile-nav__link']);
    }

    /**
     * @throws InvalidConfigException
     */
    protected function getIconName($label): string
    {
        return match ($label) {
            'Профиль' => 'user',
            'Коллекции' => 'paintings',
            'Избранное' => 'heart',
            'Настройки' => 'gear',
            'Выход' => 'exit',
            default => throw new InvalidConfigException('No icon specified for label: ' . $label),
        };
    }

    protected function isItemActive(array $item): bool
    {
        $url = Yii::$app->request->url;
        $routeUrl = Yii::$app->urlManager->createUrl([$item['url'], 'username' => Yii::$app->user->identity->username]);

        return $url === $routeUrl;
    }
}