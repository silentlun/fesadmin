<?php
use yii\db\Migration;

class m160505_082203_category extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'type' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'parentid' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'catname' => $this->string(30)->notNull(),
            'catdir' => $this->string(30)->notNull(),
            'image' => $this->string()->notNull()->defaultValue(''),
            'category_template' => $this->string()->notNull()->defaultValue(''),
            'list_template' => $this->string()->notNull()->defaultValue(''),
            'show_template' => $this->string()->notNull()->defaultValue(''),
            'page_template' => $this->string()->notNull()->defaultValue(''),
            'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'ismenu' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx-parentid', '{{%category}}', 'parentid,ismenu,sort,id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
    
}
