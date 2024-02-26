<?php

use yii\db\Migration;

/**
 * Class m240226_113615_workhour
 */
class m240226_113615_workhour extends Migration
{
    private $tableName = '{{%workhour}}';
    private $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'plan' => $this->decimal(10, 2),
            'work' => $this->decimal(10, 2),
            'workday' => $this->date(),
        ], $this->tableOptions);

        $this->createIndex('workhour_index_day', $this->tableName, 'workday');
        $this->createIndex('workhour_index_user_id', $this->tableName, 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240226_113615_workhour cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240226_113615_workhour cannot be reverted.\n";

        return false;
    }
    */
}
