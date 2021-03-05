<?php

namespace backend\models;

use Yii;
use common\helpers\Tree;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parentid
 * @property string $url
 * @property integer $listorder
 * @property integer $display
 */
class Menu extends \yii\db\ActiveRecord
{
    const DISPLAY_YES = 1;
    const DISPLAY_NO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'route'], 'required'],
            [['name', 'route'], 'trim'],
            [['parentid', 'sort', 'display'], 'integer'],
            [['name', 'route', 'icon'], 'string', 'max' => 255],
            [['parentid', 'sort'], 'default', 'value' => 0],
            ['display', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'parentid' => Yii::t('app', 'Parentid'),
            'route' => Yii::t('app', 'Route'),
            'sort' => Yii::t('app', 'Sort'),
            'display' => Yii::t('app', 'Display'),
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

    public function beforeSave($insert)
    {
        if (strncmp($this->route, '/', 1) !== 0) $this->route = '/'.$this->route;
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes){
        $auth = \Yii::$app->authManager;
        if ($insert){
            
            if ($auth->getPermission($this->route) === null && $this->route) {
                $permission = $auth->createPermission($this->route);
                $permission->description = $this->name;
                $auth->add($permission);
            }
        }else{
            $name = Yii::$app->request->get("name", "");
            if ($name) {
                $permission = $auth->getPermission($name);
                if( $permission->name != $this->route ){//修改权限名称
                    $permission->name = $this->route;
                    $permission->description = $this->name;
                    $auth->update($name, $permission);
                }
            }
            
        }
        parent::afterSave($insert, $changedAttributes);
    }
    public function beforeDelete(){
        $auth = \Yii::$app->authManager;
        $permission = $auth->getPermission($this->route);
        $auth->remove($permission);
        return parent::beforeDelete();
    }
}
