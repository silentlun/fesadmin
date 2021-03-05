<?php
/**
 * AfterLoginBehavior.php
 * @author: allen
 * @date  2020年6月24日上午11:15:43
 * @copyright  Copyright igkcms
 */
namespace backend\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\User;

class AfterLoginBehavior extends Behavior
{
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin'
        ];
    }
    
    public function afterLogin($event)
    {
        if ($model = $event->identity) {
            $model->prev_login_time = $model->last_login_time;
            $model->prev_login_ip = $model->last_login_ip;
            $model->last_login_time = time();
            $model->last_login_ip = Yii::$app->request->userIP;
            if ($model->save()) {
                return true;
            }
        }
        return false;
    }
}