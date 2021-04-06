<?php
namespace common\traits;
/**
 * BaseFrontendAction.php
 * @author: allen
 * @date  2021年3月23日上午11:47:17
 * @copyright  Copyright igkcms
 */

use Yii;
use common\models\Message;
use common\models\Profile;

trait BaseFrontendAction
{
    
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!Yii::$app->user->isGuest){
                if ($action->id != 'profile'){
                    $profile = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
                    if (!$profile) {
                        \Yii::$app->params['profileStatus'] = false;
                    }
                }
                $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'status' => 0, 'delete_at' => 0])->count();
                \Yii::$app->params['messageCount'] = $messageCount;
            }
            
            return true;
        }
        
        return false;
    }
}