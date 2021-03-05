<?php

use yii\db\Migration;

/**
 * Class m200413_050457_setting
 */
class m200413_050457_setting extends Migration
{
    const TBL_NAME = '{{%setting}}';
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
            'type' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->text(),
            'field' => $this->string(50)->notNull()->defaultValue(''),
            'fieldlabel' => $this->string(50)->notNull()->defaultValue(''),
        ], $tableOptions);
        $this->createIndex('idx-type', self::TBL_NAME, 'type');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /* echo "m200413_050457_config cannot be reverted.\n";

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
        echo "m200413_050457_config cannot be reverted.\n";

        return false;
    }
    */
}
