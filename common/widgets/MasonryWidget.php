<?php

namespace common\widgets;

use common\components\widgets\BaseWidget;
use yii\data\ActiveDataProvider;

class MasonryWidget extends BaseWidget
{
    public ActiveDataProvider $provider;

    public string $containerClass = 'masonry';

    public string $itemView = 'includes/_card';

    public string $pjaxId = 'masonry-pjax';

    public function run()
    {
        return $this->render('index', [
            'provider' => $this->provider,
            'containerClass' => $this->containerClass,
            'itemView' => $this->itemView,
            'pjaxId' => $this->pjaxId
        ]);
    }
}