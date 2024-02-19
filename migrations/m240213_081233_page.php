<?php

use yii\db\Migration;

/**
 * Class m240213_081233_page
 */
class m240213_081233_page extends Migration
{
    private $tableName = '{{%page}}';
    private $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'code' => $this->string(20),
        ], $this->tableOptions);

        $this->createIndex('page_index_code', $this->tableName, 'code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240213_081233_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240213_081233_page cannot be reverted.\n";

        return false;
    }
    */
}
