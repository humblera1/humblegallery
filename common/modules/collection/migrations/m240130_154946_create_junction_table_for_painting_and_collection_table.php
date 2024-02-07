<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%painting_collection}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%painting}}`
 * - `{{%collection}}`
 */
class m240130_154946_create_junction_table_for_painting_and_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%painting_collection}}', [
            'painting_id' => $this->integer()->comment('ID картины'),
            'collection_id' => $this->integer()->comment('ID коллекции'),
            'created_at' => $this->integer()->notNull()->comment('Время добавления'),
            'PRIMARY KEY(painting_id, collection_id)',
        ]);

        // creates index for column `painting_id`
        $this->createIndex(
            '{{%idx-painting_collection-painting_id}}',
            '{{%painting_collection}}',
            'painting_id'
        );

        // add foreign key for table `{{%painting}}`
        $this->addForeignKey(
            '{{%fk-painting_collection-painting_id}}',
            '{{%painting_collection}}',
            'painting_id',
            '{{%painting}}',
            'id',
            'CASCADE'
        );

        // creates index for column `collection_id`
        $this->createIndex(
            '{{%idx-painting_collection-collection_id}}',
            '{{%painting_collection}}',
            'collection_id'
        );

        // add foreign key for table `{{%collection}}`
        $this->addForeignKey(
            '{{%fk-painting_collection-collection_id}}',
            '{{%painting_collection}}',
            'collection_id',
            '{{%collection}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // drops foreign key for table `{{%painting}}`
        $this->dropForeignKey(
            '{{%fk-painting_collection-painting_id}}',
            '{{%painting_collection}}'
        );

        // drops index for column `painting_id`
        $this->dropIndex(
            '{{%idx-painting_collection-painting_id}}',
            '{{%painting_collection}}'
        );

        // drops foreign key for table `{{%collection}}`
        $this->dropForeignKey(
            '{{%fk-painting_collection-collection_id}}',
            '{{%painting_collection}}'
        );

        // drops index for column `collection_id`
        $this->dropIndex(
            '{{%idx-painting_collection-collection_id}}',
            '{{%painting_collection}}'
        );

        $this->dropTable('{{%painting_collection}}');
    }
}
