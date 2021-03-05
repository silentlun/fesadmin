<?php
/**
 * SettingForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use common\models\Setting;

class AlipayForm extends Setting
{
    public $alipay_appId;
    public $alipay_rsaPrivateKey;
    public $alipay_rsaPublicKey;
    
    public function attributeLabels(){
        return [
            'alipay_appId' => '支付宝APPID',
            'alipay_rsaPrivateKey' => '支付宝私钥',
            'alipay_rsaPublicKey' => '支付宝公钥',
        ];
    }
    
    public function rules(){
        return [
            [
                [
                    'alipay_appId',
                    'alipay_rsaPrivateKey',
                    'alipay_rsaPublicKey',
                ],
                'string'
            ],
        ];
    }
    
}