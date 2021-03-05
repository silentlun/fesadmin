<?php

use yii\db\Migration;

/**
 * Class m200330_084942_attachment
 */
class m200330_084942_attachment extends Migration
{
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
        
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey()->unsigned(),
            'module' => $this->string(20)->notNull(),
            'filename' => $this->string()->notNull(),
            'filepath' => $this->string()->notNull(),
            'filesize' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'fileext' => $this->string(15)->notNull(),
            'isimage' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //echo "m200330_084942_attachment cannot be reverted.\n";
        $this->dropTable('{{%attachment}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200330_084942_attachment cannot be reverted.\n";

        return false;
    }
    */
}
