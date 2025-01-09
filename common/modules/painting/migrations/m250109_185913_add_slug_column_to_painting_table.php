<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%painting}}`.
 */
class m250109_185913_add_slug_column_to_painting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('painting', 'slug', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('painting', 'slug');
    }
}
