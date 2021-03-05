<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property string $title
 * @property string|null $content
 * @property int $status
 * @property int $delete_at
 * @property int $created_at
 * @property int $updated_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%message}}';
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    static public $passTemplate = "您好，您报名参赛的作品：{title}已经通过审核，您的参赛编号为：{content}";
    static public $rejectTemplate = "您好，您报名参赛的作品：{title}未能通过审核，原因是：{content}";

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id', 'status', 'delete_at'], 'integer'],
            [['title'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['status', 'delete_at'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_id' => Yii::t('app', 'From ID'),
            'to_id' => Yii::t('app', 'To ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'delete_at' => Yii::t('app', 'Delete At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function sendMessage($event)
    {
        $model = new self();
        //$model->setAttributes($event, false);
        $model->from_id = $event->from_id;
        $model->to_id = $event->to_id;
        if ($event->status == Contest::STATUS_ACTIVE) {
            $model->title = '报名参赛作品审核已通过';
            $model->content = strtr(self::$passTemplate, [
                '{title}' => $event->title,
                '{content}' => $event->content,
            ]);
        } else {
            $model->title = '报名参赛作品未通过审核';
            $model->content = strtr(self::$rejectTemplate, [
                '{title}' => $event->title,
                '{content}' => $event->content,
            ]);
        }
        return $model->save();
    }
    public function sendRejectMessage($event)
    {
        
    }
}
