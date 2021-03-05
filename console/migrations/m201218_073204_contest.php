<?php

use yii\db\Migration;

/**
 * Class m201218_073204_contest
 */
class m201218_073204_contest extends Migration
{
    const TBL_NAME = '{{%contest}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'num' => $this->string(15)->notNull()->defaultValue(''),
            'title' => $this->string()->notNull()->defaultValue(''),
            'type_id' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'user_id' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'student' => $this->string(100)->notNull()->defaultValue(''),
            'teacher' => $this->string(100)->notNull()->defaultValue(''),
            'file' => $this->string()->notNull()->defaultValue(''),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx-user', self::TBL_NAME, 'user_id,id');
        $this->createIndex('idx-type', self::TBL_NAME, 'type_id,status,id');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
