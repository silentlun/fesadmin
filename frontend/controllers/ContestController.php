<?php
namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use common\helpers\Util;
use common\models\Contest;
use common\models\ContestType;
use common\models\User;
use common\models\Category;
use common\models\Profile;

class ContestController extends BaseController
{
    
    public function actionIndex()
    {
        $model = new Contest();
        if (Yii::$app->request->isPost) {
            $model->user_id = Yii::$app->user->identity->id;
            if ($model->load(Yii::$app->request->post())) {
                $model->upfile = UploadedFile::getInstance($model, 'upfile');
                if ($model->save()) {
                    $model->types = ContestType::findOne($model->type_id);
                    $model->upload();
                    return $this->redirect(['notify']);
                }
            }
            
        }
        /* if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()){
                
            }else {
                print_r($model->getFirstErrors());exit();
            }
            
            //return $this->redirect(['notify']);
        } */
        $categoryModel = Category::findOne(21);
        $bannerImg = $categoryModel->image;
        
        return $this->render('index', [
            'model' => $model,
            'bannerImg' => $bannerImg,
        ]);
    }
    
    public function actionNotify()
    {
        return $this->render('notify');
    }
    
    public function actionSearch($role)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $q = Yii::$app->request->get('q');
        $query = User::find()->select(['member.id','member.username'])
        ->with('profile')
        ->where(['member.role_id' => $role, 'member.status' => User::STATUS_ACTIVE])
        ->andFilterWhere(['like', 'member.username', $q])
        ->asArray()
        ->all();
        $status = 0;
        if ($query) $status = 1;
        return ['status' => $status, 'data' => $query];
    }
    

}
