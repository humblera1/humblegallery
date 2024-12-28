<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%artist}}`.
 */
class m241228_065157_add_slug_column_to_artist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('artist', 'slug', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('artist', 'slug');
    }
}
