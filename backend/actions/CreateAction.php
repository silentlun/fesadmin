<?php
/**
 * CreateAction.php
 * @author: allen
 * @date  2020年9月15日下午1:54:23
 * @copyright  Copyright igkcms
 */
namespace backend\actions;

use Yii;
use yii\base\Action;

class CreateAction extends Action
{
    public $model = null;
    public $modelClass;
    
    public function run()
    {
        $model = $this->getModel();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Save Success'));
            return $this->controller->redirect(['index']);
        }
        return $this->controller->render('create', [
            'model' => $model,
        ]);
    }
    
    public function getModel()
    {
        if( $this->model !== null ){
            $model = $this->model;
            $this->model instanceof Closure && $model = call_user_func($this->model);
        }else {
            $model = Yii::createObject([
                'class' => $this->modelClass,
            ]);
        }
        return $model;
    }
}
