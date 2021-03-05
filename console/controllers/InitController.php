<?php
/**
* 初始化用户 
*
* @author  Allen
* @date  2016-4-14 上午10:34:27
* @copyright  Copyright allen
*/
namespace console\controllers;
use backend\models\Admin;

class InitController extends \yii\console\Controller {
    /**
     * Create Init User
     */
    public function actionAdmin(){
        echo "Create init user ...\n";
        $username = $this->prompt('Input UserName:');
        $email  = $this->prompt("Input Email for $username :");
        $password = $this->prompt("Input password for $username :");
        
        $model = new Admin();
        $model->username = $username;
        $model->email = $email;
        $model->password = $password;
        //$model->generateAuthKey();
        
        if (!$model->save()){
            foreach ($model->getErrors() as $errors){
                foreach ($errors as $e){
                    echo "$e\n";
                }
            }
            return 1;
        }
        return 0;
    }
}

?>