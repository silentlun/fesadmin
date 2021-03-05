<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\helpers\Util;

/**
 * Signup form
 */
class EmailForm extends Model
{
    const SCENARIO_SEND = 'send';
    const SCENARIO_UPDATE = 'update';
    public $email;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 50],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该电子邮件地址已被使用。'],
            ['verifyCode', 'validateCode', 'on' => 'update'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'verifyCode' => '验证码',
        ];
    }
    
    public function scenarios()
    {
        return [
            self::SCENARIO_SEND => ['email'],
            self::SCENARIO_UPDATE => ['email', 'verifyCode'],
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
    
    public function updateEmail()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->email = $this->email;
        return $user->save();
        
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        
        $code = Util::randomString(6);
        $session = Yii::$app->session;
        $session['captcha'] = [
            'code' => $code,
            'expire_time' => time()+600,
        ];
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-update'],
                ['code' => $code]
            )
            ->setTo($this->email)
            ->setSubject('绑定邮箱验证通知')
            ->send();
    }
}
