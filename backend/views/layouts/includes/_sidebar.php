<?php

use common\models\Admin;
use hail812\adminlte\widgets\Menu as NotMyMenu;
use yii\web\View;
use yii\widgets\Menu;
use backend\components\widgets\Menu as MyMenu;

/**
 * @var View $this
 */

/** @var Admin $admin */
$admin = Yii::$app->user->identity;
?>

<aside class="main-sidebar">
    <div class="sidebar block">
        <a href="/" class="sidebar__logo">
            <span class="brand-text"><?= Yii::$app->id ?></span>
        </a>
        <nav class="sidebar__content">
            <?= MyMenu::widget([
                'items' => [
                    [
                        'label' => 'Назначение ролей',
                        'icon' => 'gear',
                        'url' => ['/roles'],
                        'visible' => Yii::$app->user->identity->isSuperadmin(),
                    ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'users',
                        'url' => ['/user']
                    ],
                    [
                        'label' => 'Художники',
                        'icon' => 'brush',
                        'url' => ['/artist']
                    ],
                    [
                        'label' => 'Картины',
                        'icon' => 'image',
                        'url' => ['/painting']
                    ],
                    [
                        'label' => 'Направления',
                        'icon' => 'monument',
                        'url' => ['/movement']
                    ],
                ]
            ]); ?>
        </nav>
    </div>
</aside>