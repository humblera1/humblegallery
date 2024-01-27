<?php

use yii\helpers\Url;
use yii\web\UrlManager;

?>

<section class="profile__sidebar">
    <aside class="profile__sidebar-navigation">
        <ul>
            <li class="navigation__li">
                <a class="navigation__link" href="<?= Url::to(['']) ?>">
                    <i class="navigation__icon icon-ic-elements"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <span>Общее</span>
                </a>
            </li>
        </ul>
    </aside>
</section>
