<?php

use yii\db\Migration;
use yii\db\Query;
use yii\helpers\Console;

/**
 * Class m231217_060037_create_and_assign_superadmin_role
 */
class m231217_060037_create_and_assign_superadmin_role extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $superadmin = $auth->createRole('superadmin');
        $superadmin->description = 'Главный администратор';

        $auth->add($superadmin);

        $success = Console::ansiFormat('Создана роль главного администратора', [Console::FG_BLUE]);
        echo $success . PHP_EOL;

        $auth->assign($superadmin, 1);

        $success = Console::ansiFormat('Роль главного администратора успешно назначена', [Console::FG_BLUE]);
        echo $success . PHP_EOL;

    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $superadmin = $auth->getRole('superadmin');

        $auth->revoke($superadmin, 1);
        $auth->remove($superadmin);
    }
}
