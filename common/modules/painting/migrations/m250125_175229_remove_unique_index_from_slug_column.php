<?php

use yii\db\Migration;

/**
 * Class m250125_175229_remove_unique_index_from_slug_column
 */
class m250125_175229_remove_unique_index_from_slug_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex(
            'slug',
            'painting'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createIndex(
            'slug',
            'painting',
            'slug',
            true
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250125_175229_remove_unique_index_from_slug_column cannot be reverted.\n";

        return false;
    }
    */
}
