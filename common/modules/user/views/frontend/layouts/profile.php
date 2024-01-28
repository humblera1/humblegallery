<?php

use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <div class="profile">
        <?= $this->render('includes/_sidebar'); ?>
        <div class="profile__content">
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>