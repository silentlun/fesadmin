<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\Tree;

/**
 * This is the model class for table "{{%menu_frontend}}".
 *
 * @property int $id
 * @property int $parentid
 * @property string $name
 * @property string $route
 * @property int $display
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 */
class MenuFrontend extends \yii\db\ActiveRecord
{
    const DISPLAY_YES = 1;
    const DISPLAY_NO = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_frontend}}';
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
            [['parentid', 'display', 'sort'], 'integer'],
            [['name', 'route'], 'required'],
            [['name', 'route'], 'trim'],
            [['name', 'route', 'target'], 'string', 'max' => 255],
            [['parentid', 'sort'], 'default', 'value' => 0],
            ['display', 'default', 'value' => self::DISPLAY_YES],
            ['target', 'default', 'value' => '_self'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parentid' => Yii::t('app', 'Parentid'),
            'name' => Yii::t('app', 'Name'),
            'route' => '链接',
            'display' => '导航显示',
            'target' => '打开方式',
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * 获取分类数组
     */
    protected static function _getMenu(){
        return self::find()->orderBy('sort asc,id asc')->indexBy('id')->asArray()->all();
    }
    /**
     * 获取分类数组
     */
    public static function getMenu(){
        return self::_getMenu();
    }
    /**
     * 获取分类树形结构
     */
    public static function getMenuTree(){
        $treeObj = new Tree(self::_getMenu());
        $treeObj->nbsp = '  ';
        return $treeObj->getTree(0);
    }
    /**
     * 获取分类树形结构
     */
    public static function getMenuGrid(){
        $treeObj = new Tree(self::_getMenu());
        $treeObj->icon = ['&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ '];
        $treeObj->nbsp = '&nbsp&nbsp&nbsp';
        return $treeObj->getGridTree(0);
    }
}
