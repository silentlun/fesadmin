<?php
/**
 * ClearController.php
 * @author: allen
 * @date  2020年4月23日上午9:24:30
 * @copyright  Copyright igkcms
 */
namespace backend\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\FileHelper;

class ClearController extends Controller
{
    /*
     * 清除后台缓存  
     */
    public function actionBackend()
    {
        FileHelper::removeDirectory(Yii::getAlias('@runtime/cache'));
        $path = Yii::getAlias('@backend/web/assets');
        $fp = opendir($path);
        while (false !== ($file = readdir($fp))) {
            if (! in_array($file, ['.', '..', '.gitignore'])) {
                FileHelper::removeDirectory($path . DIRECTORY_SEPARATOR . $file);
            }
        }
        if (Yii::$app->request->isAjax){
            \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return ['code' => 200, 'message' => Yii::t('app', 'Operation Success')];
        }else{
            Yii::$app->session->setFlash('success', Yii::t('app', 'Operation Success'));
            return $this->goHome();
        }
    }
    
    /*
     * 清除前台缓存
     */
    public function actionFrontend()
    {
        FileHelper::removeDirectory(Yii::getAlias('@frontend/runtime/cache'));
        $path = Yii::getAlias('@frontend/web/assets');
        $fp = opendir($path);
        while (false !== ($file = readdir($fp))) {
            if (! in_array($file, ['.', '..', '.gitignore'])) {
                FileHelper::removeDirectory($path . DIRECTORY_SEPARATOR . $file);
            }
        }
        if (Yii::$app->request->isAjax){
            \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return ['code' => 200, 'message' => Yii::t('app', 'Operation Success')];
        }else{
            Yii::$app->session->setFlash('success', Yii::t('app', 'Operation Success'));
            return $this->goHome();
        }
    }
}