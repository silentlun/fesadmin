<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%partner}}".
 *
 * @property int $id
 * @property string $title
 * @property string $logo
 * @property string $url
 * @property int $status
 * @property int $listorder
 * @property int $created_at
 * @property int $updated_at
 */
class Partner extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%partner}}';
    }
    
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
            [['title'], 'required'],
            [['title', 'url'], 'trim'],
            [['status', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['title', 'logo', 'url'], 'string', 'max' => 255],
            ['sort', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'logo' => Yii::t('app', 'Logo'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function afterSave($insert, $changedAttributes){
        Attachment::apiUpdate('partner-'.$this->id);
        
        parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        Attachment::apiDelete('partner-'.$this->id);
    }
}
