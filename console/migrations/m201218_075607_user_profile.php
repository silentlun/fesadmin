<?php

use yii\db\Migration;

/**
 * Class m201218_075607_member_profile
 */
class m201218_075607_user_profile extends Migration
{
    const TBL_NAME = '{{%member_profile}}';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->tinyInteger()->unsigned()->notNull()->unique(),
            'province' => $this->string(50)->notNull()->defaultValue(''),
            'city' => $this->string(50)->notNull()->defaultValue(''),
            'town' => $this->string(50)->notNull()->defaultValue(''),
            'school' => $this->string(100)->notNull()->defaultValue(''),
            'college' => $this->string(100)->notNull()->defaultValue(''),
            'profession' => $this->string(100)->notNull()->defaultValue(''),
            'class' => $this->string(100)->notNull()->defaultValue(''),
            'company' => $this->string(100)->notNull()->defaultValue(''),
            'teaching' => $this->string(100)->notNull()->defaultValue(''),
            'address' => $this->string()->notNull()->defaultValue(''),
            'postcode' => $this->string(20)->notNull()->defaultValue(''),
        ], $tableOptions);
        $this->createIndex('idx-user', self::TBL_NAME, 'user_id');
    }
    
    public function down()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
