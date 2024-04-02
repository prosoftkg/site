<?php

use yii\db\Migration;

/**
 * Class m240215_084901_yg_board
 */
class m240215_084901_yg_board extends Migration
{
    private $tableName = '{{%yg_board}}';
    private $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'yg_id' => $this->string(50),
            'yg_project_id' => $this->string(50),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->tableOptions);
        $this->createIndex('board_index_ygid', $this->tableName, 'yg_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240215_084901_yg_board cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240215_084901_yg_board cannot be reverted.\n";

        return false;
    }
    */
}
