<?php

namespace common\widgets;

use common\components\traits\widgets\WithCustomPath;
use yii\base\Widget;

class ModalWidget extends Widget
{
    use WithCustomPath;

    public static bool $overlayRendered = false;

    public ?string $toggleButton = null;

    public string $position = 'center';

    public function init(): void
    {
        parent::init();

        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        $needToRenderOverlay = !self::$overlayRendered;

        self::$overlayRendered = true;

        return $this->render('index', [
            'content' => $content,
            'needToRenderOverlay' => $needToRenderOverlay,
            'toggleButton' => $this->toggleButton,
            'position' => $this->position,
        ]);
    }
}