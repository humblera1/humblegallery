<?php

use yii\db\Migration;

/**
 * Class m240104_063143_create_admin_and_moderator_roles
 */
class m240104_063143_create_admin_and_moderator_roles extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Модератор';

        $auth->add($admin);
        $auth->add($moderator);

    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('admin');
        $moderator = $auth->getRole('moderator');

        $auth->remove($admin);
        $auth->remove($moderator);
    }
}
