<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%position}}".
 *
 * @property int $posid
 * @property int $modelid
 * @property int $catid
 * @property string $name
 * @property int $maxnum
 * @property int $listorder
 */
class Position extends \yii\db\ActiveRecord
{
    public static $modules = ['content' => '内容模型'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelid', 'catid', 'maxnum', 'sort'], 'integer'],
            [['modelid', 'catid', 'maxnum', 'sort'], 'default','value' => 0],
            [['name','module'], 'required'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 255],
            [['module'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'posid' => Yii::t('app', 'Posid'),
            'module' => Yii::t('app', 'Module'),
            'modelid' => Yii::t('app', 'Modelid'),
            'catid' => Yii::t('app', 'Catid'),
            'name' => Yii::t('app', 'Name'),
            'maxnum' => Yii::t('app', 'Maxnum'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    public function getModules($module)
    {
        return self::$modules[$module];
    }
    
    /**
     * 获取分类数组
     */
    public static function getPosition($module = 'content'){
    	return self::find()->where(['module' => $module])->orderBy('sort asc,posid asc')->indexBy('posid')->asArray()->all();
    }
}
