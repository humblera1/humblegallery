<?php

use yii\helpers\Url;
use yii\web\UrlManager;

?>

<section class="profile__sidebar">
    <aside class="profile__sidebar-navigation">
        <ul>
            <li class="navigation__li navigation__li_active">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon fa-solid fa-house-user"></i>
                    <span>Информация</span>
                </a>
            </li>
            <li class="navigation__li">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon fa-solid fa-images"></i>
                    <span>Коллекции</span>
                </a>
            </li>
            <li class="navigation__li">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon fa-solid fa-chart-column"></i>
                    <span>Мои курсы</span>
                </a>
            </li>
            <li class="navigation__li">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon fa-solid fa-heart"></i>
                    <span>Избранное</span>
                </a>
            </li>
            <li class="navigation__li">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon fa-solid fa-gear"></i>
                    <span>Настройки</span>
                </a>
            </li>
            <li class="navigation__li navigation__li_exit" style="display:none">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon fa-solid fa-right-from-bracket"></i>
                    <span>Выход</span>
                </a>
            </li>
        </ul>
    </aside>
</section>

<?php

$js = <<<JS
    
JS;

$this->registerJs($js);

?>
