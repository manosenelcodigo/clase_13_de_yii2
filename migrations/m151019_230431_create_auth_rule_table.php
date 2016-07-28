<?php

use yii\db\Schema;
use yii\db\Migration;

class m151019_230431_create_auth_rule_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{auth_rule}}', [
            'name'          => $this->string(64)->notNull(),
            'data'          => $this->text(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ], $tableOptions);
        
        $this->addPrimaryKey('auth_rule_name', 'auth_rule', 'name');
    }

    public function down()
    {
        $this->dropTable('{{auth_rule}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
