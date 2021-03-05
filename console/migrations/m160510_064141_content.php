<?php

use yii\db\Migration;

class m160510_064141_content extends Migration
{
    const TBL_NAME = '{{%content}}';
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'catid' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'subtitle' => $this->string()->notNull()->defaultValue(''),
            'thumb' => $this->string()->notNull()->defaultValue(''),
            'keywords' => $this->string()->notNull()->defaultValue(''),
            'description' => $this->text(),
            'content' => $this->text(),
            'username' => $this->string(20)->notNull()->defaultValue(''),
            'copyfrom' => $this->string()->notNull()->defaultValue(''),
            'template' => $this->string()->notNull()->defaultValue(''),
            'url' => $this->string()->notNull()->defaultValue(''),
            'posid' => $this->string(50)->notNull()->defaultValue(''),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'islink' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx-catid', self::TBL_NAME, 'catid,status,sort,id');
    }

    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
