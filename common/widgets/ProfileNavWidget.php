<?php

namespace common\widgets;

use common\helpers\Html;
use Yii;
use yii\base\Widget;

class ProfileNavWidget extends Widget
{
    public array $items = [];

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
        $label = Html::encode($item['label']);
        $url = Html::encode($item['url']);
        $isActive = Yii::$app->request->url === $url ? 'profile-nav__item_active' : '';

        return Html::tag('li', Html::a($label, $url), ['class' => "profile-nav__item $isActive"]);
    }
}