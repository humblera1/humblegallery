<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%painting}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%technique}}`
 */
class m240104_160512_add_technique_id_column_to_painting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%painting}}', 'technique_id', $this->integer()->notNull()->comment('Техника'));

        // creates index for column `technique_id`
        $this->createIndex(
            '{{%idx-painting-technique_id}}',
            '{{%painting}}',
            'technique_id'
        );

        // add foreign key for table `{{%technique}}`
        $this->addForeignKey(
            '{{%fk-painting-technique_id}}',
            '{{%painting}}',
            'technique_id',
            '{{%technique}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%technique}}`
        $this->dropForeignKey(
            '{{%fk-painting-technique_id}}',
            '{{%painting}}'
        );

        // drops index for column `technique_id`
        $this->dropIndex(
            '{{%idx-painting-technique_id}}',
            '{{%painting}}'
        );

        $this->dropColumn('{{%painting}}', 'technique_id');
    }
}
