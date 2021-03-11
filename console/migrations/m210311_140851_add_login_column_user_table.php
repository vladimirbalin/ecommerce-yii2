<?php

use yii\db\Migration;

/**
 * Class m210311_140851_add_login_column_user_table
 */
class m210311_140851_add_login_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'login', $this->string(255)->notNull()->after('id'));
        $this->addColumn('{{%user}}', 'firstname', $this->string(45)->notNull()->after('login'));
        $this->addColumn('{{%user}}', 'lastname', $this->string(45)->notNull()->after('firstname'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'login');
        $this->dropColumn('{{%user}}', 'firstname');
        $this->dropColumn('{{%user}}', 'lastname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210311_140851_add_login_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
