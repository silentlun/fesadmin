<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 */
class User extends \common\models\User
{
    public $password;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'sex'], 'required'],
            [['username', 'sex'], 'string', 'max' => 20],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' =>function($query){
                $query->andWhere(['not', ['id' => $this->id]]);
            }, 'message' => '该邮箱地址已被使用。'],
            
            ['mobile', 'trim'],
            ['mobile', 'required'],
            ['mobile', 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/'],
            ['mobile', 'string', 'max' => 20],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'filter' =>function($query){
                $query->andWhere(['not', ['id' => $this->id]]);
            },'message' => '该手机号码已被使用。'],
        ];
    }
    
    public function validateEmail($attribute, $params)
    {
        if (!in_array($this->$attribute, ['USA', 'Web'])) {
            $this->addError($attribute, 'The country must be either "USA" or "Web".');
        }
    }
    
    public function validateMobile($attribute, $params)
    {
        if (!in_array($this->$attribute, ['USA', 'Web'])) {
            $this->addError($attribute, 'The country must be either "USA" or "Web".');
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => '姓名',
            'sex' => '性别',
            'mobile' => '手机号',
            'avatar' => '头像',
        ];
    }
}
