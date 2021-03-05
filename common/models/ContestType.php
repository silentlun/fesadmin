<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%contest_type}}".
 *
 * @property int $id
 * @property string $name
 * @property string $subname
 * @property int $sort
 */
class ContestType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contest_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'subname'], 'required'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['subname'], 'string', 'max' => 10],
            ['sort', 'default', 'value' => 0],
            ['status', 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'subname' => Yii::t('app', 'Subname'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
    public static function getTypes()
    {
        return self::find()->select(['name'])->orderBy('sort asc,id asc')->indexBy('id')->column();
    }
}
