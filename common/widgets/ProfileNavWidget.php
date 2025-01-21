<?php

namespace common\widgets;

use common\helpers\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class ProfileNavWidget extends Widget
{
    protected bool $isOwner = false;

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
            'onlyByOwner' => true,
        ],
        [
            'label' => 'Выход',
            'url' => '/auth/logout',
            'onlyByOwner' => true,
        ],
    ];

    public function init(): void
    {
        $this->inspectCurrentUser();

        parent::init();
    }

    /**
     * @throws InvalidConfigException
     */
    public function run(): string
    {
        $class = $this->isOwner ? 'profile-nav profile-nav_owner' : 'profile-nav';

        return Html::tag('ul', $this->renderItems(), ['class' => $class]);
    }

    /**
     * Since the url always contains the username, which is unique, we find out if the profile is viewed by the owner by simple comparison...
     *
     * @return void
     */
    protected function inspectCurrentUser(): void
    {
        if (!($authUser = Yii::$app->user->identity)) {
            return;
        }

        $this->isOwner = $authUser->username === Yii::$app->request->get('username');
    }

    /**
     * @throws InvalidConfigException
     */
    protected function renderItems(): string
    {
        $itemsHtml = '';

        foreach ($this->items as $item) {
            $itemsHtml .= $this->renderItem($item);
        }

        return $itemsHtml;
    }

    /**
     * @throws InvalidConfigException
     */
    protected function renderItem(array $item): string
    {
        if (ArrayHelper::getValue($item, 'onlyByOwner', false) && !$this->isOwner) {
            return '';
        }

        $label = $item['label'];
        $url = $item['url'];

        $isActive = $this->isItemActive($item) ? 'profile-nav__item_active' : '';

        return Html::tag('li', $this->renderItemContent($label, $url), ['class' => "profile-nav__item $isActive"]);
    }

    /**
     * @throws InvalidConfigException
     */
    protected function renderItemContent(string $itemLabel, string $itemUrl): string
    {
        $itemContent = Html::tag('div',
            Html::icon($this->getIconName($itemLabel)),
            ['class' => 'profile-nav__icon']
        );
        $itemContent .= Html::tag('p', $itemLabel, ['class' => 'profile-nav__label']);

        return Html::a(
            $itemContent,
            [
                $itemUrl,
                'username' => Yii::$app->request->get('username')
            ],
            ['class' => 'profile-nav__link']
        );
    }

    /**
     * @throws InvalidConfigException
     */
    protected function getIconName(string $label): string
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
        $currentUrl = Yii::$app->request->url;
        $itemUrl = Yii::$app->urlManager->createUrl([$item['url'], 'username' => Yii::$app->request->get('username')]);

        return $currentUrl === $itemUrl || (str_contains($currentUrl, 'collections') && str_contains($itemUrl, 'collections'));
    }
}