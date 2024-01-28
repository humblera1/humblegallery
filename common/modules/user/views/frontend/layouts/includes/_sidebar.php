<?php

use frontend\components\widgets\ProfileNavbar;

?>

<section class="profile__sidebar">
    <aside class="profile__sidebar-navigation">
        <?= ProfileNavbar::widget([
            'items' => [
                [
                    'label' => 'Информация',
                    'icon' => 'house-user',
                    'section' => 'info',
                    'active' => true,
                ],
                [
                    'label' => 'Коллекции',
                    'icon' => 'images',
                    'section' => 'collections',
                ],
                [
                    'label' => 'Мои курсы',
                    'icon' => 'chart-column',
                    'section' => 'courses',
                ],
                [
                    'label' => 'Избранное',
                    'icon' => 'heart',
                    'section' => 'favorites',
                ],
                [
                    'label' => 'Настройки',
                    'icon' => 'cog',
                    'section' => 'settings',
                ],
            ],
        ]); ?>
    </aside>
</section>

