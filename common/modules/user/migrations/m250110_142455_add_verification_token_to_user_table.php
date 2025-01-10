<?php

use yii\db\Migration;

/**
 * Class m250110_142455_add_verification_token_to_user_table
 */
class m250110_142455_add_verification_token_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->unique()->after('auth_key'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'verification_token');
    }
}
