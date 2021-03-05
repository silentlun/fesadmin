<?php
/**
 * UpdateAction.php
 * @author: allen
 * @date  2020年9月15日下午1:54:28
 * @copyright  Copyright igkcms
 */
namespace backend\actions;

use Yii;
use yii\base\Action;

class UpdateAction extends Action
{
    public $model = null;
    public $modelClass;
    
    public function run()
    {
        $model = $this->getModel();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
            //return $this->redirect(['index', 'eventid' => $model->event_id]);
            return $this->controller->goBack();
        }
        Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
        return $this->controller->render('update', [
            'model' => $model,
        ]);
    }
    
    private function getModel()
    {
        if($this->model === null) {
            $model = Yii::createObject([
                'class' => $this->modelClass,
            ]);
            $primaryKeys = $model->getPrimaryKey(true);
            $condition = [];
            foreach ($primaryKeys as $key => $abandon) {
                $condition[$key] = Yii::$app->request->get($key, null);
                if( $condition[$key] === null ){
                    unset($condition[$key]);
                }
            }
            $model = call_user_func([$this->modelClass, 'findOne'], $condition);
        }else{
            $model = $this->model;
            if( $this->model instanceof Closure){
                $model = call_user_func($this->model);
            }
        }
        return $model;
    }
}