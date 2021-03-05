<?php

use yii\db\Migration;

/**
 * Class m210202_021608_menu_frontend
 */
class m210202_021608_menu_frontend extends Migration
{
    const TBL_NAME = '{{%menu_frontend}}';
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
            'parentid' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'name' => $this->string()->notNull(),
            'route' => $this->string()->notNull(),
            'display' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
