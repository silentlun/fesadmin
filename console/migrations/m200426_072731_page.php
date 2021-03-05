<?php

use yii\db\Migration;

/**
 * Class m200426_072731_page
 */
class m200426_072731_page extends Migration
{
    const TBL_NAME = '{{%page}}';
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
            'catid' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'thumb' => $this->string()->notNull()->defaultValue(''),
            'content' => $this->text(),
            'template' => $this->string()->notNull()->defaultValue(''),
            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->createIndex('idx-catid', self::TBL_NAME, 'catid');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }

}
