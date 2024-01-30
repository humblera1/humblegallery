<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%collection}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m240130_153529_create_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%collection}}', [
            'id' => $this->primaryKey()->comment('ID коллекции'),
            'title' => $this->string(255)->notNull()->comment('Название коллекции'),
            'user_id' => $this->integer()->notNull()->comment('ID пользователя'),
            'is_private' => $this->boolean()->defaultValue(0)->comment('Закрыта'),
            'is_archived' => $this->boolean()->defaultValue(0)->comment('В архиве'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-collection-user_id}}',
            '{{%collection}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-collection-user_id}}',
            '{{%collection}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-collection-user_id}}',
            '{{%collection}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-collection-user_id}}',
            '{{%collection}}'
        );

        $this->dropTable('{{%collection}}');
    }
}
