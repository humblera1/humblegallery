<?php

use frontend\assets\profile\ProfileAsset;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

ProfileAsset::register($this)

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <div class="profile">
        <section class="profile__sidebar">
            <?= $this->render('includes/_sidebar'); ?>
        </section>
        <div class="profile__section">
            <div class="profile__section-content">
                <?= $content ?>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>