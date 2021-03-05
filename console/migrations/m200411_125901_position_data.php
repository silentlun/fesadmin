<?php
use yii\db\Migration;

/**
 * Class m200411_125901_position_data
 */
class m200411_125901_position_data extends Migration
{

    const TBL_NAME = '{{%position_data}}';

    /**
     *
     * {@inheritdoc}
     *
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
            'content_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'catid' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'posid' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'module' => $this->string(20)->notNull(),
            'thumb' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'data' => $this->text(),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0)
        ], $tableOptions);
        $this->createIndex('idx-posid', self::TBL_NAME, 'posid,catid,content_id,sort');
        $this->createIndex('idx-module', self::TBL_NAME, 'module,content_id');
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function safeDown()
    {
        /*
         * echo "m200411_125901_position_data cannot be reverted.\n";
         *
         * return false;
         */
        $this->dropTable(self::TBL_NAME);
    }
    
    /*
     * // Use up()/down() to run migration code without a transaction.
     * public function up()
     * {
     *
     * }
     *
     * public function down()
     * {
     * echo "m200411_125901_position_data cannot be reverted.\n";
     *
     * return false;
     * }
     */
}
