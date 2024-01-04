<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subject}}`.
 */
class m240104_150155_create_subject_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subject}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->unique()->notNull()->comment('Жанр'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%subject}}');
    }
}
