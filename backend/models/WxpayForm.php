<?php
/**
 * SettingForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use common\models\Setting;

class WxpayForm extends Setting
{
    public $wxpay_jsapi_appId;
    public $wxpay_jsapi_mchId;
    public $wxpay_jsapi_key;
    public $wxpay_jsapi_appSecret;
    public $wxpay_h5_appId;
    public $wxpay_h5_mchId;
    public $wxpay_h5_key;
    public $wxpay_h5_appSecret;
    public $wxpay_app_appId;
    public $wxpay_app_mchId;
    public $wxpay_app_key;
    public $wxpay_app_appSecret;
    
    public function attributeLabels(){
        return [
            'wxpay_jsapi_appId' => 'JSAPI支付APPID',
            'wxpay_jsapi_mchId' => 'JSAPI支付商户号',
            'wxpay_jsapi_key' => 'JSAPI支付密钥',
            'wxpay_jsapi_appSecret' => '公众帐号secert',
            'wxpay_h5_appId' => 'H5支付APPID',
            'wxpay_h5_mchId' => 'H5支付商户号',
            'wxpay_h5_key' => 'H5支付密钥',
            'wxpay_h5_appSecret' => '公众帐号secert',
            'wxpay_app_appId' => 'APP支付APPID',
            'wxpay_app_mchId' => 'APP支付商户号',
            'wxpay_app_key' => 'APP支付密钥',
            'wxpay_app_appSecret' => '公众帐号secert',
        ];
    }
    
    public function rules(){
        return [
            [
                [
                    'wxpay_jsapi_appId',
                    'wxpay_jsapi_mchId',
                    'wxpay_jsapi_key',
                    'wxpay_jsapi_appSecret',
                    'wxpay_h5_appId',
                    'wxpay_h5_mchId',
                    'wxpay_h5_key',
                    'wxpay_h5_appSecret',
                    'wxpay_app_appId',
                    'wxpay_app_mchId',
                    'wxpay_app_key',
                    'wxpay_app_appSecret',
                ],
                'string'
            ],
        ];
    }
}