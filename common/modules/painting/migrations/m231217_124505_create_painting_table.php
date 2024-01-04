<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%painting}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%artist}}`
 */
class m231217_124505_create_painting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%painting}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'title' => $this->string(255)->notNull()->comment('Название'),
            'description' => $this->text()->comment('Описание'),
            'start_date' => $this->integer()->comment('Дата начала'),
            'end_date' => $this->integer()->comment('Дата завершения'),
            'rating' => $this->float()->defaultValue(0)->comment('Рейтинг'),
            'image_name' => $this->string(255)->comment('Изображение'),
            'artist_id' => $this->integer()->notNull()->comment('Художник'),
            'technique_id' => $this->integer()->notNull()->comment('Техника'),
            'created_at' => $this->integer()->notNull()->comment('Дата добавления'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
            'is_deleted' => $this->boolean()->defaultValue(0)->comment('В архиве'),
        ]);

        // creates index for column `artist_id`
        $this->createIndex(
            '{{%idx-painting-artist_id}}',
            '{{%painting}}',
            'artist_id'
        );

        // add foreign key for table `{{%artist}}`
        $this->addForeignKey(
            '{{%fk-painting-artist_id}}',
            '{{%painting}}',
            'artist_id',
            '{{%artist}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%artist}}`
        $this->dropForeignKey(
            '{{%fk-painting-artist_id}}',
            '{{%painting}}'
        );

        // drops index for column `artist_id`
        $this->dropIndex(
            '{{%idx-painting-artist_id}}',
            '{{%painting}}'
        );

        $this->dropTable('{{%painting}}');
    }
}
