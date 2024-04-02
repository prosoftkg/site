<?php

use yii\db\Migration;

/**
 * Class m240209_110822_user_add
 */
class m240209_110822_user_add extends Migration
{
    private $tableName = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'role', $this->string(50)->defaultValue(null));
        $this->addColumn($this->tableName, 'name', $this->string(50)->defaultValue(null));
        $this->addColumn($this->tableName, 'yougile_id', $this->string(50)->defaultValue(null));
        $this->addColumn($this->tableName, 'yougile_status', $this->string(50)->defaultValue(null));
        $this->addColumn($this->tableName, 'yougile_last_active', $this->integer()->defaultValue(0));
        $this->createIndex('user_yougile_id', $this->tableName, 'yougile_id');
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240209_110822_user_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240209_110822_user_add cannot be reverted.\n";

        return false;
    }
    */
}
