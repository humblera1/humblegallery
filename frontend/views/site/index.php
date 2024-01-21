<?php

use yii\web\View;

/**
 * @var View $this
 */

$cache = Yii::$app->cache;

$this->registerJsVar('needToShowLoginModal', $cache->get('needToShowLoginModal'));
$cache->delete('needToShowLoginModal');

$this->title = 'My Yii Application';

$js = <<<JS
    if (needToShowLoginModal) {
        showLoginModal();
    }
JS;

$this->registerJs($js);

?>
