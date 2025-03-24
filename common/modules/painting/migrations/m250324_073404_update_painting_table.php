<?php

use yii\db\Migration;

/**
 * Class m250324_073404_update_painting_table
 */
class m250324_073404_update_painting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%painting}}', 'description', $this->string(500)->comment('Описание'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%painting}}', 'description', $this->string()->comment('Описание'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_073404_update_painting_table cannot be reverted.\n";

        return false;
    }
    */
}
