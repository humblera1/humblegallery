<?php

use yii\db\Migration;

/**
 * Class m250324_072837_update_artist_table
 */
class m250324_072837_update_artist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%artist}}', 'description', $this->string(500)->comment('Описание'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%artist}}', 'description', $this->string()->comment('Описание'));
    }
}
