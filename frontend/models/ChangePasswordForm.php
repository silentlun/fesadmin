<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $password_new;
    public $password_repeat;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'password_new', 'password_repeat'], 'required'],
            [['password', 'password_new', 'password_repeat'], 'string', 'min' => 6],
            ['password_new', 'compare', 'compareAttribute' => 'password_repeat','message'=>'两次输入的新密码不一致！'],
        ];
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => '原密码',
            'password_new' => '新密码',
            'password_repeat' => '确认新密码',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function update()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = User::findOne(Yii::$app->user->identity->id);
        if (!$user->validatePassword($this->password)) {
            $this->addError('password', '原密码错误。');
            return false;
        }
        return true;
        $user->setPassword($this->password_new);
        return $user->save();

    }

}
