<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $route
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['route'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'admin.username' => '用户',
            'route' => Yii::t('app', 'Route'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'user_id']);
    }
    
    public function afterFind()
    {
        $this->description = str_replace([
            '{{%BY%}}',
            '{{%CREATED%}}',
            '{{%UPDATED%}}',
            '{{%DELETED%}}',
            '{{%ID%}}',
            '{{%RECORD%}}'
        ], [
            Yii::t('app', 'through'),
            Yii::t('app', 'created'),
            Yii::t('app', 'updated'),
            Yii::t('app', 'deleted'),
            Yii::t('app', 'id'),
            Yii::t('app', 'record')
        ], $this->description);
        $this->description = preg_replace_callback('/\(created_at\) : (\d{1,10})=>(\d{1,10})/', function ($matches) {
            return str_replace([$matches[1], $matches[2]], [Yii::$app->getFormatter()->asDate((int)$matches[1]), Yii::$app->getFormatter()->asDate((int)$matches[2])], $matches[0]);
        }, $this->description);
            $this->description = preg_replace_callback('/\(updated_at\) : (\d{1,10})=>(\d{1,10})/', function ($matches) {
                return str_replace([$matches[1], $matches[2]], [Yii::$app->getFormatter()->asDate((int)$matches[1]), Yii::$app->getFormatter()->asDate((int)$matches[2])], $matches[0]);
            }, $this->description);
                parent::afterFind();
    }
}
