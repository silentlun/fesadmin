<?php
/**
 * UploadForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Contest;

class ContestClearForm extends Model
{
    
    public $verifyCode;
    
    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],
        ];
    }
    
    public function attributeLabels(){
        return [
            'verifyCode' => '验证码',
        ];
    }
    
}