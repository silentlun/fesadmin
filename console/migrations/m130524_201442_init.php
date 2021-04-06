<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    const TBL_NAME = '{{%member}}';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string(20)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(50)->unique(),
            'access_token' => $this->string()->defaultValue(null),
            'sex' => $this->string(20)->notNull()->defaultValue(''),
            'email' => $this->string(50)->notNull()->unique(),
            'mobile' => $this->string(15)->notNull()->unique(),
            'role_id' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'group_id' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'amount' => $this->decimal(8,2)->notNull()->defaultValue(0.00),
            'point' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'avatar' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'verification_token' => $this->string()->defaultValue(null),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
