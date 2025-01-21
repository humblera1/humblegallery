<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $verifyLink
 */

?>

Для подтверждения почты необходимо перейти по ссылке:

<?= Html::a(Html::encode($verifyLink), $verifyLink) ?>
