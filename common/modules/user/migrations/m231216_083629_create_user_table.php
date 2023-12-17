<?php

namespace common\modules\painting\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m231216_083629_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'username' => $this->string(255)->notNull()->comment('Логин'),
            'email' => $this->string(255),
            'password_hash' => $this->string()->notNull(),
            'name' => $this->string(255)->comment('Имя'),
            'surname' => $this->string(255)->comment('Фамилия'),
            'is_verified' => $this->boolean()->comment('Подтверждён'),
            'is_blocked' => $this->boolean()->comment('Заблокирован'),
            'created_at' => $this->integer()->notNull()->comment('Создан'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлён'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
