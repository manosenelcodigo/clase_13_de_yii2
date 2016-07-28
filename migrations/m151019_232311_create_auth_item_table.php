<?php

use yii\db\Schema;
use yii\db\Migration;

class m151019_232311_create_auth_item_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{auth_item}}', [
            'name'          => $this->string(64)->notNull(),
            'type'          => $this->integer()->notNull(),
            'description'   => $this->text(),
            'rule_name'     => $this->string(64),
            'data'          => $this->text(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ], $tableOptions);
        
        $this->addPrimaryKey('auth_item_name', 'auth_item', 'name');
        
        $this->addForeignKey(
            'auth_item_rule_name_name', 'auth_item', 'rule_name', 'auth_rule', 'name', 'set null', 'cascade'
        );
        
        $this->createIndex('type_auth_item', 'auth_item', 'type');
    }

    public function down()
    {
        $this->dropTable('{{auth_item}}');
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
