<?php

use yii\db\Migration;

/**
 * Class m240513_062116_yg_board_add
 */
class m240513_062116_yg_board_add extends Migration
{
    private $tableName = '{{%yg_board}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'title', $this->string(50)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240513_062116_yg_board_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240513_062116_yg_board_add cannot be reverted.\n";

        return false;
    }
    */
}
