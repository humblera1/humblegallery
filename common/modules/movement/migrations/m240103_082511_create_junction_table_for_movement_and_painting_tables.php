<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%movement_painting}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%movement}}`
 * - `{{%painting}}`
 */
class m240103_082511_create_junction_table_for_movement_and_painting_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%movement_painting}}', [
            'movement_id' => $this->integer(),
            'painting_id' => $this->integer(),
            'PRIMARY KEY(movement_id, painting_id)',
        ]);

        // creates index for column `movement_id`
        $this->createIndex(
            '{{%idx-movement_painting-movement_id}}',
            '{{%movement_painting}}',
            'movement_id'
        );

        // add foreign key for table `{{%movement}}`
        $this->addForeignKey(
            '{{%fk-movement_painting-movement_id}}',
            '{{%movement_painting}}',
            'movement_id',
            '{{%movement}}',
            'id',
            'NO ACTION'
        );

        // creates index for column `painting_id`
        $this->createIndex(
            '{{%idx-movement_painting-painting_id}}',
            '{{%movement_painting}}',
            'painting_id'
        );

        // add foreign key for table `{{%painting}}`
        $this->addForeignKey(
            '{{%fk-movement_painting-painting_id}}',
            '{{%movement_painting}}',
            'painting_id',
            '{{%painting}}',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%movement}}`
        $this->dropForeignKey(
            '{{%fk-movement_painting-movement_id}}',
            '{{%movement_painting}}'
        );

        // drops index for column `movement_id`
        $this->dropIndex(
            '{{%idx-movement_painting-movement_id}}',
            '{{%movement_painting}}'
        );

        // drops foreign key for table `{{%painting}}`
        $this->dropForeignKey(
            '{{%fk-movement_painting-painting_id}}',
            '{{%movement_painting}}'
        );

        // drops index for column `painting_id`
        $this->dropIndex(
            '{{%idx-movement_painting-painting_id}}',
            '{{%movement_painting}}'
        );

        $this->dropTable('{{%movement_painting}}');
    }
}
