<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

$imageName = $this->params['image'] ?? 'default.png';
$imagePath = '/images/' . $imageName;

?>

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div class="auth">
    <div class="auth__preview">
        <img class="auth__image" src="<?= $imagePath ?>" alt="Auth Image">
    </div>
    <section class="auth__content">
        <h1 class="title"><?= Html::encode($this->title) ?></h1>
        <?= $content ?>
    </section>
</div>

<?php $this->endContent(); ?>
