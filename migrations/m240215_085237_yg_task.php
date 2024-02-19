<?php

use yii\db\Migration;

/**
 * Class m240215_085237_yg_task
 */
class m240215_085237_yg_task extends Migration
{
    private $tableName = '{{%yg_task}}';
    private $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'column_id' => $this->integer(),
            'yg_id' => $this->string(50),
            'yg_column_id' => $this->string(50),
            'title' => $this->string(),
            'description' => $this->text(),
            'archived' => $this->boolean()->defaultValue(false),
            'completed' => $this->boolean()->defaultValue(false),
            'completed_at' => $this->integer(),
            'time_plan' => $this->decimal(10, 2),
            'time_work' => $this->decimal(10, 2),
            'deadline' => $this->integer(),
            'created_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex('task_index_ygid', $this->tableName, 'yg_id');
        $this->createIndex('task_index_comleted', $this->tableName, 'completed');
        $this->createIndex('task_index_comleted_at', $this->tableName, 'completed_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240215_085237_yg_task cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240215_085237_yg_task cannot be reverted.\n";

        return false;
    }
    */
}
