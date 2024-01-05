<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%artist}}`.
 */
class m231217_122018_create_artist_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%artist}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string()->notNull()->comment('Имя'),
            'born' => $this->integer()->comment('Дата рождения'),
            'died' => $this->integer()->comment('Дата смерти'),
            'description' => $this->string()->comment('Описание'),
            'image_path' => $this->string()->comment('Изображение'),
            'rating' => $this->float()->comment('Рейтинг'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
            'is_deleted' => $this->boolean()->defaultValue(0)->comment('ID'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%artist}}');
    }
}
