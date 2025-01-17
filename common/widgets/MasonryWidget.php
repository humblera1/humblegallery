<?php

namespace common\widgets;

use common\components\widgets\BaseWidget;
use yii\data\ActiveDataProvider;

class MasonryWidget extends BaseWidget
{
    public ActiveDataProvider $provider;

    public string $containerClass = 'paintings__masonry';

    public string $itemView = '@common/views/_painting-card';

    public string $pjaxId = 'paintings-pjax-container';

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