<?php
namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use frontend\models\User;
use common\helpers\Util;
use frontend\models\EmailForm;
use frontend\models\MobileForm;
use frontend\models\ChangePasswordForm;
use common\models\Profile;
use common\models\Contest;
use common\models\Message;

class MemberController extends BaseController
{
    
    
    public function actionIndex()
    {
        $profile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
        return $this->render('index', ['profile' => $profile]);
    }
    
    public function actionProfile()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $profile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
        if ($user->role_id == User::ROLE_STUDENT) {
            $profile->scenario = Profile::SCENARIO_STUDENT;
        } else {
            $profile->scenario = Profile::SCENARIO_TEACHER;
        }
        
        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            $isValid = $user->validate();
            $isValid = $profile->validate() && $isValid;
            if ($isValid) {
                $user->save(false);
                $profile->save(false);
                Yii::$app->session->setFlash('success', '个人资料修改成功！');
                return $this->redirect(['member/index']);
            }
        }
        return $this->render('profile', ['user' => $user, 'profile' => $profile]);
    }
    
    public function actionContest()
    {
        
        $query = Contest::find()->with('user', 'type')
        ->where(['user_id' => Yii::$app->user->identity->id])
        ->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('contest', [
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionContestTeam()
    {
        $user_id = Yii::$app->user->identity->id;
        $query = Contest::find()->with('user', 'type')
        ->where("find_in_set($user_id, student)")
        ->orWhere("find_in_set($user_id, teacher)")
        ->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $dataProvider->setSort(false);
        return $this->render('contest-team', [
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionContestUpdate($id)
    {
        $model = Contest::findOne($id);
        $model->scenario = $model::SCENARIO_FRONTEND_UPDATE;
        if ($model->status != Contest::STATUS_ACTIVE) $model->status = Contest::STATUS_INACTIVE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->upfile = UploadedFile::getInstance($model, 'upfile');
            if ($model->upfile != null) {
                $model->types = $model->type;
                $model->upload();
            }
            Yii::$app->session->setFlash('success', '参赛资料修改成功！');
            return $this->goBack();
        }
        Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
        
        //$students = User::find()->where(['in', 'id', $model->student])->asArray()->all();
        $student = explode(',', $model->student);
        $teacher = explode(',', $model->teacher);
        $students = User::find()->select(['member.id','member.username'])
        ->with('profile')
        ->where(['in', 'id', $student])
        ->asArray()
        ->all();
        $teachers = User::find()->select(['member.id','member.username'])
        ->with('profile')
        ->where(['in', 'id', $teacher])
        ->asArray()
        ->all();
        //print_r($students);exit;
        foreach ($students as $k => $r){
            $students[$k]['id'] = $r['id'];
            $students[$k]['name'] = $r['username'];
            $students[$k]['school'] = $r['profile']['school'];
            $students[$k]['college'] = $r['profile']['college'];
            $students[$k]['selected'] = 1;
        }
        foreach ($teachers as $k => $r){
            $teachers[$k]['id'] = $r['id'];
            $teachers[$k]['name'] = $r['username'];
            $teachers[$k]['company'] = $r['profile']['company'];
            $teachers[$k]['teaching'] = $r['profile']['teaching'];
            $teachers[$k]['selected'] = 1;
        }
        return $this->render('contest-update', [
            'model' => $model,
            'students' => $students,
            'teachers' => $teachers,
        ]);
    }
    
    public function actionChangepwd()
    {
        $model = new ChangePasswordForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                return ['status' => 1, 'msg' => '密码修改成功！'];
            } else {
                $tmp_error = $model->getFirstErrors();
                foreach($model->activeAttributes() as $error) {
                    if(isset( $tmp_error[$error]) && !empty($tmp_error[$error])){
                        return ['status' => 0, 'msg' => $tmp_error[$error]];
                    }
                }
            }
            return ['status' => 0, 'msg' => '密码修改失败！'];
        }
        
        return $this->render('changepwd', [
            'model' => $model,
        ]);
    }
    
    public function actionMessage()
    {
        $query = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'delete_at' => 0])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('message', [
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionMessageStatus()
    {
        $id = Yii::$app->request->post('id');
        Message::updateAll(['status' => 1], ['id' => $id]);
        Yii::$app->session->setFlash('success', '操作成功！');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 0, 'msg' => '操作成功'];
    }
    
    public function actionMessageDelete()
    {
        $id = Yii::$app->request->post('id');
        Message::updateAll(['delete_at' => time()], ['id' => $id]);
        Yii::$app->session->setFlash('success', '删除成功！');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 0, 'msg' => '删除成功'];
    }
    

}
