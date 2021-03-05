<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\helpers\Util;

/**
 * Signup form
 */
class MobileForm extends Model
{
    const SCENARIO_SEND = 'send';
    const SCENARIO_UPDATE = 'update';
    public $mobile;
    public $smsCode;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['mobile', 'trim'],
            ['mobile', 'required'],
            ['mobile', 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/'],
            ['mobile', 'string', 'max' => 20],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已被使用。'],
            ['smsCode', 'validateCode', 'on' => 'update'],
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha', 'on' => 'send'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mobile' => '手机号',
            'smsCode' => '验证码',
            'verifyCode' => '图形码',
        ];
    }
    
    public function scenarios()
    {
        return [
            self::SCENARIO_SEND => ['mobile', 'verifyCode'],
            self::SCENARIO_UPDATE => ['mobile', 'verifyCode', 'smsCode'],
        ];
    }
    
    public function validateCode($attribute, $params)
    {
        $session = Yii::$app->session;
        if (!isset($session['captcha']) || $session['captcha']['expire_time'] < time()) {
            $this->addError($attribute, '验证码已过期。');
        } else {
            if ($this->$attribute != $session['captcha']['code']) {
                $this->addError($attribute, '验证码无效。');
            }
        }
        $session->remove('captcha');
    }
    
    public function updateMobile()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->mobile = $this->mobile;
        return $user->save();
        
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public function sendSms()
    {
        
        /* $code = Util::randomNumber(6);
        $session = Yii::$app->session;
        $session['captcha'] = [
            'code' => $code,
            'expire_time' => time()+600,
        ]; */
        return Util::sendSms($this->mobile, ['code' => $code], 'changemobile');
    }
}
