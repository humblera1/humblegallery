<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%collection}}`.
 */
class m250113_121150_add_columns_to_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%collection}}', 'slug', $this->string());
        $this->addColumn('{{%collection}}', 'cover', $this->string()->null()->after('title')->comment('Cover Image Path'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%collection}}', 'slug');
        $this->dropColumn('{{%collection}}', 'cover');
    }
}
