<?php

use yii\db\Migration;

/**
 * Class m240120_171906_modify_is_verify_and_is_blocked_columns
 */
class m240120_171906_modify_is_verify_and_is_blocked_columns extends Migration
{
    protected string $tableName = "{{%user}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->tableName, 'is_verified', $this->boolean()->defaultValue(0)->comment('Подтверждён'));
        $this->alterColumn($this->tableName, 'is_blocked', $this->boolean()->defaultValue(0)->comment('Заблокирован'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableName, 'is_verified', $this->boolean()->comment('Подтверждён'));
        $this->alterColumn($this->tableName, 'is_blocked', $this->boolean()->comment('Заблокирован'));
    }
}
