<?php

use yii\db\Migration;

/**
 * Class m210311_140738_remove_username_column_user_table
 */
class m210311_140738_remove_username_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user}}', 'username');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210311_140738_remove_username_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210311_140738_remove_username_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
