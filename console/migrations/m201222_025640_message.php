<?php

use yii\db\Migration;

/**
 * Class m201222_025640_message
 */
class m201222_025640_message extends Migration
{
    const TBL_NAME = '{{%message}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'from_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'to_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'delete_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx-userid', self::TBL_NAME, 'to_id,delete_at,id');
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
