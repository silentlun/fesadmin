<?php
namespace backend\models;
use Yii;
use yii\base\Model;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions;
    public $roles;
    
    public function rules()
    {
        return [
        ['name', 'required'],
        ['name', 'trim'],
        
        ['name', 'string', 'length' => [2, 8]],
        ['permissions', 'trim'],
        ['description', 'trim'],
        ];
    }
    public function attributeLabels()
    {
        return [
        'name' => '角色名称',
        'description' => '角色描述',
        ];
    }
    public function findModel($name)
    {
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        $temp = $authManager->getPermissionsByRole($role->name);
        
        $permissions = [];
        foreach ($temp as $_k=>$permission){
            $permissions[] = $permission->name;
        }
        //print_r($permissions);exit;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->permissions = $permissions;
        $this->roles = array_keys( $authManager->getChildRoles($role->name) );
        return $this;
    }
    public function deleteRole()
    {
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($this->name);
        if ($authManager->remove($role)) {
            /* Event::trigger(CustomLog::className(), CustomLog::EVENT_AFTER_DELETE, new CustomLog([
                'sender' => $this,
            ])); */
            return true;
        } else {
            return false;
        }
    }
}