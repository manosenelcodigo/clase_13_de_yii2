<?php

use yii\db\Schema;
use yii\db\Migration;

class m151020_143252_create_auth_assignment_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{auth_assignment}}', [
            'item_name'     => $this->string(64)->notNull(),
            'user_id'       => $this->string(64)->notNull(),
            'created_at'    => $this->integer(),
        ], $tableOptions);
        
        $this->addPrimaryKey('auth_assignment_pk', 'auth_assignment', ['item_name', 'user_id']);
        
        $this->addForeignKey(
            'item_name_auth_assignment_fk', 'auth_assignment', 'item_name', 'auth_item', 'name', 'cascade', 'cascade'
        );
    }

    public function down()
    {
        $this->dropTable('{{auth_assignment}}');
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
