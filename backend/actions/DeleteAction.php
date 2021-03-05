<?php
/**
* Delete Action 
*
* @author  Allen
* @date  2020-4-8 下午1:35:14
* @copyright  Copyright igkcms
*/
namespace backend\actions;

use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class DeleteAction extends Action {
    
    /**
    * string model类名
    */
    public $modelClass;
    
    /**
    * string  传递参数ID
    */
    public $paramSign = 'id';
    
    public function run(){
        $request = Yii::$app->request;
        if ($request->isPost){
            $ids = $request->post($this->paramSign);
            if (is_array($ids)){
                foreach ($ids as $id){
                    $model = call_user_func([$this->modelClass, 'findOne'], $id);
                    if (!$model->delete()){
                        $errorIds[] = $id;
                    }
                }
            }else{
                $model = call_user_func([$this->modelClass, 'findOne'], $ids);
                if (!$model->delete()){
                    $errorIds[] = $ids;
                }
            }
        }
        if ($request->isAjax){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ['code' => 200, 'message' => Yii::t('app', 'Success')];
        }else{
            Yii::$app->session->setFlash('success', Yii::t('app', 'Operation Success'));
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
    }
}