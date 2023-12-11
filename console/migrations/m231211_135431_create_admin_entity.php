<?php

use yii\db\Migration;
use yii\helpers\Console;

/**
 * Class m231211_135431_create_admin_entity
 */
class m231211_135431_create_admin_entity extends Migration
{
    public function safeUp()
    {
        $password = YII_ENV_DEV ? '4815162342' : Yii::$app->security->generateRandomString(12);
        $passwordHash = Yii::$app->security->generatePasswordHash($password);

        $this->insert('{{%admin}}', [
            'username' => 'humblerat',
            'email' => 'humblerat@mail.ru',
            'password_hash' => $passwordHash,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $separator = Console::ansiFormat(str_repeat('-', 100), [Console::FG_BLUE]);
        $message = Console::ansiFormat('Пароль от администратора: ', [Console::FG_BLUE]);
        $password = Console::ansiFormat($password, [Console::BOLD, Console::FG_CYAN]);

        echo PHP_EOL . $separator . PHP_EOL;
        echo $message . $password . PHP_EOL;
        echo $separator . PHP_EOL . PHP_EOL;
    }

    public function safeDown()
    {
        $this->truncateTable('{{%admin}}');
    }
}
