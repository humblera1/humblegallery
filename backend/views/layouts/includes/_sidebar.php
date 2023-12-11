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
                        'label' => 'Пользователи',
                        'icon' => 'users',
                        'url' => ['']
                    ],
                    [
                        'label' => 'Картины',
                        'icon' => 'image',
                        'url' => ['']
                    ],
                ]
            ]); ?>
        </nav>
    </div>
</aside>