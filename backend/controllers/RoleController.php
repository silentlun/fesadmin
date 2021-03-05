<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use backend\models\Menu;
use common\helpers\Tree;
use common\helpers\Util;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class RoleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    

    /**
     * 角色列表
     */
    public function actionIndex()
    {
        
        $model = Yii::$app->authManager->getRoles();
        return $this->render('index',['model' => $model]);
    }
    
    /**
     * 添加角色
     */
    public function actionCreate(){
        $auth = \Yii::$app->authManager;
        $model = new RoleForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $role = $auth->getRole($model->name);
            if (!$role) {
                $role = $auth->createRole($model->name);
                $role->description = $model->description;
                $auth->add($role);
            }
            
            return $this->redirect(['index']);
    
        }else{
            return $this->render('create', [
                    'model' => $model,
                    ]);
        }
    }
    
    /**
     * 编辑角色
     */
    public function actionUpdate($name){
        $auth = \Yii::$app->authManager;
        $model = new RoleForm();
        $model = $model->findModel($name);
        //print_r($model);
        //exit;
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            //print_r($model->name);exit;
            $role = $auth->getRole($name);
            if( $role->name != $model->name ){//修改角色名称
                if( $auth->getRole($model->name) !== null ){
                    $this->addError('name', Yii::t('app', 'Role exists'));
                    return false;
                }
            }
            $role->name = $model->name;
            $role->description = $model->description;
            
            $auth->update($name, $role);
            
            $result['status'] = 1;
            $result['message'] = '保存成功';
            
            
            return $this->redirect(['index']);
            
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * 删除角色
     */
    public function actionDelete($name){
        $model = new RoleForm();
        $model = $model->findModel($name);
        $model->deleteRole();
        return $this->redirect(['index']);
    }
    
    /**
     * 角色权限
     */
    public function actionPriv($name){
        $auth = \Yii::$app->authManager;
        
        if (Yii::$app->request->isPost){
            $permissions = Yii::$app->request->post('permissions');
            if ($permissions && is_array($permissions)) {
                $permissions = array_unique($permissions);
            }
            $role = $auth->getRole($name);
            //分配权限
            $oldPermissions = [];
            if ($auth->getPermissionsByRole($name)) {
                $oldPermissions = ArrayHelper::getColumn($auth->getPermissionsByRole($name), 'name');
            }
            is_array($permissions) ? $newPermissions = $permissions : $newPermissions = [];
            //需要增加的权限
            $needAdds = array_diff($newPermissions, $oldPermissions);
            
            foreach ($needAdds as $new) {
                $auth->addChild($role, $auth->getPermission($new));
            }
            //需要删除的权限
            $needRemoves = array_diff($oldPermissions, $newPermissions);
            foreach ($needRemoves as $old) {
                $auth->removeChild($role, $auth->getPermission($old));
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
            return $this->redirect(['index']);
            
            /* \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return ['code' => 200, 'message' => Yii::t('app', 'Success')]; */
            
        }
        $model = new RoleForm();
        $model = $model->findModel($name);
        $result = Menu::getMenu();
        foreach ($result as $k => $r){
            $result[$k]['checked'] = in_array($r['route'], $model->permissions) ? ' checked' : '';
            $result[$k]['level'] = Util::getLevel($r['id'], $result);
            $result[$k]['parentid_node'] = $r['parentid'] ? ' class="child-of-node-'.$r['parentid'].'"' : '';
        }
        $str  = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:30px;'>\$spacer<input type='checkbox' name='permissions[]' value='\$route' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
				</tr>";
        $tree = new Tree($result);
        $tree->icon = ['│ ','├─ ','└─ '];
        $tree->nbsp = '&nbsp;&nbsp;';
        $menus = $tree->getTableTree(0, $str);
        
        return $this->renderAjax('role_priv', [
            'menus' => $menus,
            'model' => $model,
            'name' => $name,
        ]);
    }
    
}
