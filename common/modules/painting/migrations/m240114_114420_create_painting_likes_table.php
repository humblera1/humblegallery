<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%painting_likes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%painting}}`
 * - `{{%user}}`
 */
class m240114_114420_create_painting_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%painting_likes}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'painting_id' => $this->integer()->notNull()->comment('Картина'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
        ]);

        // creates index for column `painting_id`
        $this->createIndex(
            '{{%idx-painting_likes-painting_id}}',
            '{{%painting_likes}}',
            'painting_id'
        );

        // add foreign key for table `{{%painting}}`
        $this->addForeignKey(
            '{{%fk-painting_likes-painting_id}}',
            '{{%painting_likes}}',
            'painting_id',
            '{{%painting}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-painting_likes-user_id}}',
            '{{%painting_likes}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-painting_likes-user_id}}',
            '{{%painting_likes}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%painting}}`
        $this->dropForeignKey(
            '{{%fk-painting_likes-painting_id}}',
            '{{%painting_likes}}'
        );

        // drops index for column `painting_id`
        $this->dropIndex(
            '{{%idx-painting_likes-painting_id}}',
            '{{%painting_likes}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-painting_likes-user_id}}',
            '{{%painting_likes}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-painting_likes-user_id}}',
            '{{%painting_likes}}'
        );

        $this->dropTable('{{%painting_likes}}');
    }
}
