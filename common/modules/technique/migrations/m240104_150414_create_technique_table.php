<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%technique}}`.
 */
class m240104_150414_create_technique_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%technique}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->unique()->notNull()->comment('Техника'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%technique}}');
    }
}
