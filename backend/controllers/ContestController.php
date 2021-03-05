<?php

namespace backend\controllers;

use Yii;
use common\models\Contest;
use backend\models\ContestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\models\ContestVerifyForm;
use common\traits\BaseAction;
use moonland\phpexcel\Excel;
use backend\models\User;
use yii\helpers\ArrayHelper;
use backend\models\ContestClearForm;
use yii\helpers\FileHelper;

/**
 * ContestController implements the CRUD actions for ContestData model.
 */
class ContestController extends Controller
{
    use BaseAction;
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
     * Lists all ContestData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->setSort(false);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ContestData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ContestData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post()) && $model->edit()) {
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
            return $this->goBack();
        }
        Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    public function actionVerify()
    {
        $model = new ContestVerifyForm();
        $model->id = Yii::$app->request->get('id');
        $model->ids = Yii::$app->request->get('ids');
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Verify Success'));
            return $this->redirect(['index']);
        }
        //$model->ids = Yii::$app->request->get('ids');
        return $this->renderAjax('verify', [
            'model' => $model,
        ]);
    }
    
    public function actionDownload()
    {
        return \Yii::$app->response->sendFile('path/to/file.txt');
    }
    
    public function actionManage()
    {
        /* $allModels = Contest::find()->with('type')->orderBy('id DESC')->asArray()->all();
        
        foreach ($allModels as $k => $model) {
            $allModels[$k]['type'] = $model['type']['name'];
            $allModels[$k]['role'] = '队长';
            $user = User::getUserOne($model['user_id']);
            $allModels[$k]['username'] = $user['username'];
            $allModels[$k]['email'] = $user['email'];
            $allModels[$k]['mobile'] = $user['mobile'];
            $allModels[$k]['province'] = $user['profile']['province'];
            $allModels[$k]['city'] = $user['profile']['city'];
            $allModels[$k]['school'] = $user['profile']['school'];
            $allModels[$k]['college'] = $user['profile']['college'];
            $allModels[$k]['profession'] = $user['profile']['profession'];
            $allModels[$k]['class'] = $user['profile']['class'];
            $allModels[$k]['address'] = $user['profile']['address'];
            $allModels[$k]['postcode'] = $user['profile']['postcode'];
            
        }
        $i = $j = 0;
        $students = $teachers = [];
        foreach ($allModels as $k => $model) {
            $student = User::getUserAll($model['student']);
            foreach ($student as $user) {
                $students[$i] = $model;
                $students[$i]['role'] = '学生';
                $students[$i]['username'] = $user['username'];
                $students[$i]['email'] = $user['email'];
                $students[$i]['mobile'] = $user['mobile'];
                $students[$i]['province'] = $user['profile']['province'];
                $students[$i]['city'] = $user['profile']['city'];
                $students[$i]['school'] = $user['profile']['school'];
                $students[$i]['college'] = $user['profile']['college'];
                $students[$i]['profession'] = $user['profile']['profession'];
                $students[$i]['class'] = $user['profile']['class'];
                $students[$i]['address'] = $user['profile']['address'];
                $students[$i]['postcode'] = $user['profile']['postcode'];
                $i++;
            }
        }
        foreach ($allModels as $k => $model) {
            $user = User::getUserOne($model['teacher']);
            $teachers[$k] = $model;
            $teachers[$k]['role'] = '指导老师';
            $teachers[$k]['username'] = $user['username'];
            $teachers[$k]['email'] = $user['email'];
            $teachers[$k]['mobile'] = $user['mobile'];
            $teachers[$k]['province'] = $user['profile']['province'];
            $teachers[$k]['city'] = $user['profile']['city'];
            $teachers[$k]['company'] = $user['profile']['company'];
            $teachers[$k]['address'] = $user['profile']['address'];
            $teachers[$k]['postcode'] = $user['profile']['postcode'];
            $i++;
        }
        $allModels = array_merge($allModels, $students, $teachers);
        ArrayHelper::multisort($allModels, 'id');
        Excel::export([
            'models' => $allModels,
            'fileName' => '参赛小组信息表_'.date('Ymd'),
            'asAttachment' => true,
            'columns' => [
                'province',
                'city',
                'id',
                'title',
                'type',
                'status',
                'username',
                'role',
                'school',
                'college',
                'profession',
                'class',
                'email',
                'mobile',
                'address',
                'postcode',
                'company',
            ],
            'headers' => [
                'province' => '省份',
                'city' => '城市',
                'id' => '序号',
                'title' => '作品名称',
                'type' => '参赛组别',
                'status' => '状态',
                'username' => '姓名',
                'role' => '身份',
                'school' => '学校',
                'college' => '学院',
                'profession' => '专业',
                'class' => '班级',
                'email' => '邮箱',
                'mobile' => '手机号',
                'address' => '地址',
                'postcode' => '邮编',
                'company' => '工作单位',
            ],
        ]);
        print_r($allModels);exit; */
        $type = Yii::$app->request->get('type');
        switch ($type) {
            case 'all':
                return $this->allData();
                break;
            case 'simple':
                return $this->simpleData();
                break;
            case 'student':
                return $this->studentData();
                break;
            case 'teacher':
                return $this->teacherData();
                break;
        }
        return $this->render('export');
    }
    
    protected function allData()
    {
        $allModels = Contest::find()->with('type')->orderBy('id ASC')->asArray()->all();
        $excelModels = [];
        /* foreach ($allModels as $k => $model) {
            $allModels[$k]['type'] = $model['type']['name'];
            $allModels[$k]['role'] = '队长';
            $user = User::getUserOne($model['user_id']);
            $allModels[$k]['username'] = $user['username'];
            $allModels[$k]['email'] = $user['email'];
            $allModels[$k]['mobile'] = $user['mobile'];
            $allModels[$k]['province'] = $user['profile']['province'];
            $allModels[$k]['city'] = $user['profile']['city'];
            $allModels[$k]['school'] = $user['profile']['school'];
            $allModels[$k]['college'] = $user['profile']['college'];
            $allModels[$k]['profession'] = $user['profile']['profession'];
            $allModels[$k]['class'] = $user['profile']['class'];
            $allModels[$k]['address'] = $user['profile']['address'];
            $allModels[$k]['postcode'] = $user['profile']['postcode'];
            
        } */
        foreach ($allModels as $k => $model) {
            $excelModels[$k]['id'] = $model['type']['subname'].$model['id'];
            $excelModels[$k]['title'] = $model['title'];
            $excelModels[$k]['status'] = $model['status'];
            $excelModels[$k]['type'] = $model['type']['name'];
            $excelModels[$k]['role'] = '队长';
            $user = User::getUserOne($model['user_id']);
            $excelModels[$k]['username'] = $user['username'];
            $excelModels[$k]['email'] = $user['email'];
            $excelModels[$k]['mobile'] = $user['mobile'];
            $excelModels[$k]['province'] = $user['profile']['province'];
            $excelModels[$k]['city'] = $user['profile']['city'];
            $excelModels[$k]['school'] = $user['profile']['school'];
            $excelModels[$k]['college'] = $user['profile']['college'];
            $excelModels[$k]['profession'] = $user['profile']['profession'];
            $excelModels[$k]['class'] = $user['profile']['class'];
            $excelModels[$k]['address'] = $user['profile']['address'];
            $excelModels[$k]['postcode'] = $user['profile']['postcode'];
            $excelModels[$k]['company'] = $user['profile']['company'];
        }
        
        $students = $teachers = $studentarr = $teacherarr = [];
        foreach ($allModels as $k => $model) {
            if (!$model['student']) continue;
            $studentModel = User::getUserAll($model['student']);
            $i = 0;
            foreach ($studentModel as $user) {
                $student['id'] = $model['type']['subname'].$model['id'];
                $student['title'] = $model['title'];
                $student['type'] = $model['type']['name'];
                $student['status'] = $model['status'];
                $student['role'] = '学生';
                $student['username'] = $user['username'];
                $student['email'] = $user['email'];
                $student['mobile'] = $user['mobile'];
                $student['province'] = $user['profile']['province'];
                $student['city'] = $user['profile']['city'];
                $student['school'] = $user['profile']['school'];
                $student['college'] = $user['profile']['college'];
                $student['profession'] = $user['profile']['profession'];
                $student['class'] = $user['profile']['class'];
                $student['address'] = $user['profile']['address'];
                $student['postcode'] = $user['profile']['postcode'];
                $student['company'] = $user['profile']['company'];
                /* $students[] = $model;
                $students[]['role'] = '学生';
                $students[]['username'] = $user['username'];
                $students[]['email'] = $user['email'];
                $students[]['mobile'] = $user['mobile'];
                $students[]['province'] = $user['profile']['province'];
                $students[]['city'] = $user['profile']['city'];
                $students[]['school'] = $user['profile']['school'];
                $students[]['college'] = $user['profile']['college'];
                $students[]['profession'] = $user['profile']['profession'];
                $students[]['class'] = $user['profile']['class'];
                $students[]['address'] = $user['profile']['address'];
                $students[]['postcode'] = $user['profile']['postcode']; */
                $i++;
                $students[] = $student;
                unset($student);
            }
            //print_r($students);
            $studentarr = array_merge($studentarr, $students);
            unset($students);
        }
        //print_r($studentarr);exit;
        foreach ($allModels as $k => $model) {
            if (!$model['teacher']) continue;
            $teacherModel = User::getUserAll($model['teacher']);
            foreach ($teacherModel as $user) {
                $teacher['id'] = $model['type']['subname'].$model['id'];
                $teacher['title'] = $model['title'];
                $teacher['type'] = $model['type']['name'];
                $teacher['status'] = $model['status'];
                $teacher['role'] = '指导老师';
                $teacher['username'] = $user['username'];
                $teacher['email'] = $user['email'];
                $teacher['mobile'] = $user['mobile'];
                $teacher['province'] = $user['profile']['province'];
                $teacher['city'] = $user['profile']['city'];
                $teacher['school'] = $user['profile']['school'];
                $teacher['college'] = $user['profile']['college'];
                $teacher['profession'] = $user['profile']['profession'];
                $teacher['class'] = $user['profile']['class'];
                $teacher['address'] = $user['profile']['address'];
                $teacher['postcode'] = $user['profile']['postcode'];
                $teacher['company'] = $user['profile']['company'];
                $teachers[] = $teacher;
                unset($teacher);
            }
            $teacherarr = array_merge($teacherarr, $teachers);
            unset($teachers);
            /* foreach ($student as $user) {
                $teachers[$j] = $model;
                $teachers[$j]['role'] = '指导老师';
                $teachers[$j]['username'] = $user['username'];
                $teachers[$j]['email'] = $user['email'];
                $teachers[$j]['mobile'] = $user['mobile'];
                $teachers[$j]['province'] = $user['profile']['province'];
                $teachers[$j]['city'] = $user['profile']['city'];
                $teachers[$j]['school'] = $user['profile']['school'];
                $teachers[$j]['college'] = $user['profile']['college'];
                $teachers[$j]['profession'] = $user['profile']['profession'];
                $teachers[$j]['class'] = $user['profile']['class'];
                $teachers[$j]['address'] = $user['profile']['address'];
                $teachers[$j]['postcode'] = $user['profile']['postcode'];
                $teachers[$j]['company'] = $user['profile']['company'];
                $j++;
            } */
            
        }
        //print_r($allModels);
        //$allModels = array_merge($allModels, $students);
        //$allModels = array_merge($allModels, $teachers);
        $excelModels = array_merge($excelModels, $studentarr, $teacherarr);
        ArrayHelper::multisort($excelModels, 'id');
        /* print_r($excelModels);
        print_r($studentarr);
        print_r($teacherarr);
        exit; */
        
        Excel::export([
            'models' => $excelModels,
            'fileName' => '参赛小组信息表_'.date('Ymd'),
            'asAttachment' => true,
            'columns' => [
                'province',
                'city',
                'id',
                'title',
                'type',
                'status',
                'username',
                'role',
                'school',
                'college',
                'profession',
                'class',
                'email',
                'mobile',
                'address',
                'postcode',
                'company',
            ],
            'headers' => [
                'province' => '省份',
                'city' => '城市',
                'id' => '序号',
                'title' => '作品名称',
                'type' => '参赛组别',
                'status' => '状态',
                'username' => '姓名',
                'role' => '身份',
                'school' => '学校',
                'college' => '学院',
                'profession' => '专业',
                'class' => '班级',
                'email' => '邮箱',
                'mobile' => '手机号',
                'address' => '地址',
                'postcode' => '邮编',
                'company' => '工作单位',
            ],
        ]);
    }
    
    protected function simpleData()
    {
        $models = Contest::find()->with(['type', 'user'])->orderBy('id ASC')->all();
        $allModels = [];
        foreach ($models as $k => $model) {
            $allModels[$k]['id'] = $model->type['subname'].$model->id;
            $allModels[$k]['title'] = $model->title;
            $allModels[$k]['type'] = $model->type['name'];
            $allModels[$k]['student'] = str_replace('<br>', ',', $model->students);
            $allModels[$k]['teacher'] = str_replace('<br>', ',', $model->teachers);
            $user = User::getUserOne($model['user_id']);
            $allModels[$k]['username'] = $user['username'];
            $allModels[$k]['email'] = $user['email'];
            $allModels[$k]['mobile'] = $user['mobile'];
            $allModels[$k]['province'] = $user['profile']['province'];
            $allModels[$k]['city'] = $user['profile']['city'];
            $allModels[$k]['school'] = $user['profile']['school'];
            $allModels[$k]['college'] = $user['profile']['college'];
            $allModels[$k]['profession'] = $user['profile']['profession'];
            $allModels[$k]['class'] = $user['profile']['class'];
            $allModels[$k]['address'] = $user['profile']['address'];
            $allModels[$k]['postcode'] = $user['profile']['postcode'];
        }
        Excel::export([
            'models' => $allModels,
            'fileName' => '参赛小组简表_'.date('Ymd'),
            'asAttachment' => true,
            'columns' => [
                'id',
                'title',
                'type',
                'student',
                'teacher',
                'username',
                'school',
                'college',
                'profession',
                'class',
                'email',
                'mobile',
                'address',
                'postcode',
            ],
            'headers' => [
                'id' => '序号',
                'title' => '作品名称',
                'type' => '参赛组别',
                'student' => '小组成员',
                'teacher' => '指导老师',
                'username' => '姓名',
                'school' => '学校',
                'college' => '学院',
                'profession' => '专业',
                'class' => '班级',
                'email' => '邮箱',
                'mobile' => '手机号',
                'address' => '地址',
                'postcode' => '邮编',
            ],
        ]);
    }
    
    protected function studentData()
    {
        $models = User::find()->with('profile')->where(['role_id' => User::ROLE_STUDENT])->orderBy('id DESC')->asArray()->all();
        $allModels = [];
        foreach ($models as $k => $user) {
            $allModels[$k]['id'] = $user['id'];
            $allModels[$k]['ids'] = Contest::getIds($user['id']);
            $allModels[$k]['role'] = '学生';
            $allModels[$k]['username'] = $user['username'];
            $allModels[$k]['email'] = $user['email'];
            $allModels[$k]['mobile'] = $user['mobile'];
            $allModels[$k]['province'] = $user['profile']['province'];
            $allModels[$k]['city'] = $user['profile']['city'];
            $allModels[$k]['school'] = $user['profile']['school'];
            $allModels[$k]['college'] = $user['profile']['college'];
            $allModels[$k]['profession'] = $user['profile']['profession'];
            $allModels[$k]['class'] = $user['profile']['class'];
            $allModels[$k]['address'] = $user['profile']['address'];
            $allModels[$k]['postcode'] = $user['profile']['postcode'];
            
        }
        Excel::export([
            'models' => $allModels,
            'fileName' => '学生统计表_'.date('Ymd'),
            'asAttachment' => true,
            'columns' => [
                'id',
                'ids',
                'username',
                'role',
                'province',
                'city',
                'school',
                'college',
                'profession',
                'class',
                'email',
                'mobile',
                'address',
                'postcode',
            ],
            'headers' => [
                'id' => '会员ID',
                'ids' => '组队序号',
                'username' => '姓名',
                'role' => '身份',
                'province' => '省份',
                'city' => '城市',
                'school' => '学校',
                'college' => '学院',
                'profession' => '专业',
                'class' => '班级',
                'email' => '邮箱',
                'mobile' => '手机号',
                'address' => '地址',
                'postcode' => '邮编',
            ],
        ]);
    }
    
    protected function teacherData()
    {
        $models = User::find()->with('profile')->where(['role_id' => User::ROLE_TEACHER])->orderBy('id DESC')->asArray()->all();
        $allModels = [];
        foreach ($models as $k => $user) {
            $allModels[$k]['id'] = $user['id'];
            $allModels[$k]['ids'] = Contest::getIds($user['id']);
            $allModels[$k]['role'] = '老师';
            $allModels[$k]['username'] = $user['username'];
            $allModels[$k]['email'] = $user['email'];
            $allModels[$k]['mobile'] = $user['mobile'];
            $allModels[$k]['province'] = $user['profile']['province'];
            $allModels[$k]['city'] = $user['profile']['city'];
            $allModels[$k]['company'] = $user['profile']['company'];
            $allModels[$k]['teaching'] = $user['profile']['teaching'];
            $allModels[$k]['address'] = $user['profile']['address'];
            $allModels[$k]['postcode'] = $user['profile']['postcode'];
            
        }
        Excel::export([
            'models' => $allModels,
            'fileName' => '教师统计表_'.date('Ymd'),
            'asAttachment' => true,
            'columns' => [
                'id',
                'ids',
                'username',
                'role',
                'province',
                'city',
                'company',
                'teaching',
                'email',
                'mobile',
                'address',
                'postcode',
            ],
            'headers' => [
                'id' => '会员ID',
                'ids' => '组队序号',
                'username' => '姓名',
                'role' => '身份',
                'province' => '省份',
                'city' => '城市',
                'company' => '工作单位',
                'teaching' => '授课及研究方向',
                'email' => '邮箱',
                'mobile' => '手机号',
                'address' => '地址',
                'postcode' => '邮编',
            ],
        ]);
    }
    
    public function actionClear()
    {
        $model = new ContestClearForm();
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            FileHelper::removeDirectory(Yii::getAlias('@uploads/contest'));
            Yii::$app->db->createCommand()->truncateTable(Contest::tableName())->execute();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Operation Success'));
            return $this->redirect(['manage']);
        }
        return $this->renderAjax('clear', [
            'model' => $model,
        ]);
    }
    

    /**
     * Finds the ContestData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContestData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Contest::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Contest::className(),
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 5,//最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 2,//验证码字体大小，数值越小字体越大
                'height' => 40,
                'width' => 120,
                'offset' => 4,//设置字符偏移量
            ],
        ];
    }
}
