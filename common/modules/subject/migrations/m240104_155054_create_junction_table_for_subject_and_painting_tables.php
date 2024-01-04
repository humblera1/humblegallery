<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subject_painting}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%subject}}`
 * - `{{%painting}}`
 */
class m240104_155054_create_junction_table_for_subject_and_painting_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subject_painting}}', [
            'subject_id' => $this->integer(),
            'painting_id' => $this->integer(),
            'PRIMARY KEY(subject_id, painting_id)',
        ]);

        // creates index for column `subject_id`
        $this->createIndex(
            '{{%idx-subject_painting-subject_id}}',
            '{{%subject_painting}}',
            'subject_id'
        );

        // add foreign key for table `{{%subject}}`
        $this->addForeignKey(
            '{{%fk-subject_painting-subject_id}}',
            '{{%subject_painting}}',
            'subject_id',
            '{{%subject}}',
            'id',
            'CASCADE'
        );

        // creates index for column `painting_id`
        $this->createIndex(
            '{{%idx-subject_painting-painting_id}}',
            '{{%subject_painting}}',
            'painting_id'
        );

        // add foreign key for table `{{%painting}}`
        $this->addForeignKey(
            '{{%fk-subject_painting-painting_id}}',
            '{{%subject_painting}}',
            'painting_id',
            '{{%painting}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // drops foreign key for table `{{%subject}}`
        $this->dropForeignKey(
            '{{%fk-subject_painting-subject_id}}',
            '{{%subject_painting}}'
        );

        // drops index for column `subject_id`
        $this->dropIndex(
            '{{%idx-subject_painting-subject_id}}',
            '{{%subject_painting}}'
        );

        // drops foreign key for table `{{%painting}}`
        $this->dropForeignKey(
            '{{%fk-subject_painting-painting_id}}',
            '{{%subject_painting}}'
        );

        // drops index for column `painting_id`
        $this->dropIndex(
            '{{%idx-subject_painting-painting_id}}',
            '{{%subject_painting}}'
        );

        $this->dropTable('{{%subject_painting}}');
    }
}
