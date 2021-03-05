<?php

use yii\db\Migration;

class m171116_060114_admin extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull()->defaultValue(''),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'prev_login_time' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'prev_login_ip' => $this->string(15)->notNull()->defaultValue(''),
            'last_login_time' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'last_login_ip' => $this->string(15)->notNull()->defaultValue(''),
    
            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            ], $tableOptions);
    }
    
    public function down()
    {
        $this->dropTable('{{%admin}}');
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
