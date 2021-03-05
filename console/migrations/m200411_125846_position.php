<?php

use yii\db\Migration;

/**
 * Class m200411_125846_position
 */
class m200411_125846_position extends Migration
{
	const TBL_NAME = '{{%position}}';
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
    		'posid' => $this->primaryKey()->unsigned(),
    	    'module' => $this->string(20)->notNull()->defaultValue(''),
    	    'modelid' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
    		'catid' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
    		'name' => $this->string()->notNull(),
    		'maxnum' => $this->integer()->unsigned()->notNull()->defaultValue(0),
    		'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0),
    	], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /* echo "m200411_125846_position cannot be reverted.\n";

        return false; */
    	$this->dropTable(self::TBL_NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200411_125846_position cannot be reverted.\n";

        return false;
    }
    */
}
