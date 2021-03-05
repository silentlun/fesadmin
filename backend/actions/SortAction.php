<?php
/**
 * SortAction.php
 * @author: allen
 * @date  2020年4月20日下午2:36:27
 * @copyright  Copyright igkcms
 */
namespace backend\actions;

use yii;
use yii\base\Action;
use yii\web\Response;

class SortAction extends Action {
    /**
     * string model类名
     */
    public $modelClass;
    
    public function run(){
        $request = Yii::$app->request;
        if ($request->isPost){
            $listorders = $request->post('listorders', []);
            if ($listorders){
                foreach ($listorders as $id => $listorder){
                    $model = call_user_func([$this->modelClass, 'updateAll'], ['sort' => $listorder], ['id' => $id]);
                    /* $model->sort = $listorder;
                    if (!$model->save()){
                        $errorIds[] = $id;
                    } */
                }
            }
        }
        Yii::$app->session->setFlash('success', Yii::t('app', 'Operation Success'));
        if ($request->isAjax){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ['code' => 200, 'message' => Yii::t('app', 'Operation Success')];
        }else{
            
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
    }
}