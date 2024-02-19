<?php

use yii\db\Migration;

/**
 * Class m240215_085711_yg_task_user
 */
class m240215_085711_yg_task_user extends Migration
{
    private $tableName = '{{%yg_task_user}}';
    private $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'task_id' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex('taskuser_userid', $this->tableName, 'user_id');
        $this->createIndex('taskuser_taskid', $this->tableName, 'task_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240215_085711_yg_task_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240215_085711_yg_task_user cannot be reverted.\n";

        return false;
    }
    */
}
