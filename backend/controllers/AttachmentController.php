<?php

namespace backend\controllers;

use Yii;
use common\models\Attachment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use common\components\UploadAction;
use backend\models\AttachmentAddressForm;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use backend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * AttachmentController implements the CRUD actions for Attachment model.
 */
class AttachmentController extends Controller
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
     * Lists all Attachment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attachment::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionViewLayer($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionThumbs($id)
    {
        $thumbs = [];
        $model = $this->findModel($id);
        $infos = glob(dirname(Yii::getAlias('@uploads/').$model->filepath).'/thumb_*'.basename($model->filepath));
        if ($infos) {
            foreach ($infos as $n => $thumb) {
                $thumbs[$n]['thumb_url'] = str_replace(Yii::getAlias('@uploads/'), Yii::$app->config->site_upload_url, $thumb);
                $thumbinfo = explode('_', basename($thumb));
                $thumbs[$n]['thumb_filepath'] = $thumb;
                $thumbs[$n]['width'] = $thumbinfo[1];
                $thumbs[$n]['height'] = $thumbinfo[2];
            }
        }
        
        return $this->render('thumb', [
            'thumbs' => $thumbs,
        ]);
    }
    
    public function actionThumbdelete()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $filepath = urldecode(Yii::$app->request->post('filepath'));
        
        $ext = strtolower(trim(substr(strrchr($filepath, '.'), 1, 10)));
        if(!in_array(strtoupper($ext),array('JPG','GIF','BMP','PNG','JPEG'))) return ['code' => 0, 'message' => Yii::t('app', 'Error')];
        $reslut = unlink($filepath);
        if ($reslut) {
            return ['code' => 200, 'message' => Yii::t('app', 'Success')];
        } else {
            return ['code' => 0, 'message' => Yii::t('app', 'Error')];
        }
        
    }
    
    public function actionAddress()
    {
        $filterTables = ['auth_assignment', 'auth_item', 'auth_item_child', 'auth_rule', 'migration'];
        
        $model = new AttachmentAddressForm();
        
        if ($model->load(Yii::$app->request->post())) {
            $tables = Yii::$app->db->createCommand('show tables')->queryAll();
            foreach ($tables as $k => $v) {
                $tableName = array_pop($v);
                if (in_array($tableName, $filterTables)) continue;
                $columns = Yii::$app->db->getTableSchema($tableName)->columns;
                $fields = ArrayHelper::map($columns, 'name', 'dbType');
                if ($fields) {
                    $sql = '';
                    foreach ($fields as $key=>$val) {
                        //对数据表进行过滤，只有VARCHAR、TEXT或mediumtext类型的字段才可以保存下附件的地址。
                        if (preg_match('/(varchar|text|mediumtext)+/i', $val)) {
                            $sql .= !empty($sql) ? ", `$key`=replace(`$key`, '{$model->old_attachment_path}', '{$model->new_attachment_path}')" : "`$key`=replace(`$key`, '{$model->old_attachment_path}', '{$model->new_attachment_path}')";
                        }
                    }
                    if (!empty($sql)) Yii::$app->db->createCommand("UPDATE {$tableName} SET $sql")->execute();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Operation Success'));
            return $this->redirect(['index']);
        }
        
        return $this->render('address', [
            'model' => $model,
        ]);
    }
    
    
    public function actionAlbum()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attachment::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        
        return $this->render('album', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDirectory()
    {
        
        $dir = Yii::$app->request->get('dir', '');
        $dir = str_replace(array('..\\', '../', './', '.\\', '.'), '', $dir);
        //$data = FileHelper::findDirectories($dir);
        $filepath = Yii::getAlias('@uploads/uploads/').$dir;
        $list = glob($filepath.'/'.'*');
        //if(!empty($list)) rsort($list);
        $local = str_replace(array(Yii::getAlias('@frontend/web/uploadfile/'), DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('',DIRECTORY_SEPARATOR), $filepath);
        return $this->render('directory', [
            'list' => $list,
            'local' => $local,
            'dir' => $dir
        ]);
    }

    /**
     * Creates a new Attachment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $dirname = Yii::$app->request->post('dirname');
        $basePath = Yii::getAlias('@uploads/uploads/');
        if (Yii::$app->request->isPost && $dirname) {
            FileHelper::createDirectory($basePath.$dirname);
            $this->redirect(['directory']);
        }
        return $this->renderAjax('create');
    }

    /**
     * Updates an existing Attachment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($dir)
    {
        $model = new UploadForm();
        $model->dir = $dir;

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDeleteDirFile($path)
    {
        $type = Yii::$app->request->get('type');
        $basePath = Yii::getAlias('@uploads/uploads/');
        if ($type == 'file'){
            FileHelper::unlink($basePath.$path);
        } else {
            FileHelper::removeDirectory($basePath.$path);
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['code' => 200, 'message' => Yii::t('app', 'Success')];
    }

    /**
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => UploadAction::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Attachment::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Attachment::className(),
            ],
        ];
    }
}
