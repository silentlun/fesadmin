<?php

namespace backend\controllers;

use Yii;
use backend\models\Admin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\RoleForm;
use backend\models\Menu;
use yii\helpers\ArrayHelper;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
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
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Admin::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();
        $model->setScenario('create');

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->assignRole()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');
        

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->updateRole()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \Yii::$app->authManager->revokeAll($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * 修改自己密码
     */
    public function actionUpdateSelf()
    {
        $model = Admin::findOne(['id' => Yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('self-update');
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->selfUpdate()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Success'));
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->session->setFlash('error', $err);
            }
            $model = Admin::findOne(['id' => Yii::$app->getUser()->getIdentity()->getId()]);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    

    /**
     * 角色列表
     */
    public function actionRolelist()
    {
        
        $model = Yii::$app->authManager->getRoles();
        return $this->render('roleindex',['model' => $model]);
    }
    
    /**
     * 添加角色
     */
    public function actionRolecreate(){
        $auth = \Yii::$app->authManager;
        $model = new RoleForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $role = $auth->getRole($model->name);
            if (!$role) {
                $role = $auth->createRole($model->name);
                $role->description = $model->description;
                $auth->add($role);
            }
            //分配权限
            is_array($model->permissions) ? $newPermissions = $model->permissions : $newPermissions = [];
            $newPermissions = array_unique($newPermissions);
            foreach ($newPermissions as $new) {
                //var_dump($role);var_dump($auth->getPermission($new));exit;
                $auth->addChild($role, $auth->getPermission($new));
            }
            
            return $this->redirect(['rolelist']);
    
        }else{
            return $this->render('rolecreate', [
                    'model' => $model,
                    ]);
        }
    }
    
    /**
     * 编辑角色
     */
    public function actionRoleupdate($name){
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
            //分配权限
            $oldPermissions = [];
            if ($auth->getPermissionsByRole($name)) {
                $oldPermissions = ArrayHelper::getColumn($auth->getPermissionsByRole($name), 'name');
            }
            is_array($model->permissions) ? $newPermissions = $model->permissions : $newPermissions = [];
            //计算交集
            //$intersection = array_intersect($newPermissions, $oldPermissions);
            //需要增加的权限
            $needAdds = array_diff($newPermissions, $oldPermissions);
            //需要删除的权限
            $needRemoves = array_diff($oldPermissions, $newPermissions);
            //var_dump($needRemoves);var_dump($needAdds);exit;
            if( $auth->update($name, $role) ){
                foreach ($needAdds as $new) {
                    $auth->addChild($role, $auth->getPermission($new));
                }
                foreach ($needRemoves as $old) {
                    $auth->removeChild($role, $auth->getPermission($old));
                }
            }
            
            $result['status'] = 1;
            $result['message'] = '保存成功';
            
            
            return $this->redirect(['rolelist']);
            
        }else{
            return $this->render('roleupdate', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * 删除角色
     */
    public function actionRoleudelete($name){
        $model = new RoleForm();
        $model = $model->findModel($name);
        $model->deleteRole();
        return $this->redirect(['rolelist']);
    }
    
}
