<?php
/**
 * SettingForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use common\models\Setting;

class SmtpForm extends Setting
{
    public $smtp_host;
    public $smtp_username;
    public $smtp_password;
    public $smtp_port;
    public $smtp_emcryption;
    public $smtp_nickname;
    
    public function attributeLabels(){
        return [
            'smtp_host' => '邮件服务器',
            'smtp_username' => '用户名',
            'smtp_password' => '密码',
            'smtp_port' => '邮件发送端口',
            'smtp_emcryption' => '连接类型',
            'smtp_nickname' => '发件人地址',
        ];
    }
    
    public function rules(){
        return [
            [
                [
                    'smtp_host',
                    'smtp_username',
                    'smtp_password'
                ],
                'string'
            ],
            [['smtp_port'], 'integer'],
        ];
    }

}