<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<div id="toast-widget">
    <div class="toast__container"></div>

    <?= $this->render('includes/_success'); ?>

    <?= $this->render('includes/_error'); ?>

</div>
