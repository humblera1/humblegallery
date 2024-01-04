<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%movement}}`.
 */
class m240103_072325_create_movement_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%movement}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->unique()->comment('Направление'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%movement}}');
    }
}
