<?php
/**
 * SmsForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use common\models\Setting;

class SmsForm extends Setting
{
    public $sms_access_keyId;
    public $sms_access_keySecret;
    public $sms_signName;
    
    public function attributeLabels(){
        return [
            'sms_access_keyId' => '短信Key',
            'sms_access_keySecret' => '短信Secret',
            'sms_signName' => '短信签名',
        ];
    }
    
    public function rules(){
        return [
            [
                [
                    'sms_access_keyId',
                    'sms_access_keySecret',
                    'sms_signName',
                ],
                'string'
            ],
        ];
    }
}