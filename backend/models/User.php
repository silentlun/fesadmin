<?php

namespace backend\models;

use Yii;

class User extends \common\models\User
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'on' => self::SCENARIO_CREATE],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该用户名已被使用。', 'on' => self::SCENARIO_CREATE],
            ['username', 'string', 'min' => 2, 'max' => 20],
            
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该邮箱地址已被使用。', 'on' => self::SCENARIO_CREATE],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' =>function($query){
                $query->andWhere(['not', ['id' => $this->id]]);
            }, 'message' => '该邮箱地址已被使用。', 'on' => self::SCENARIO_UPDATE],
            
            ['mobile', 'trim'],
            ['mobile', 'required'],
            ['mobile', 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/'],
            ['mobile', 'string', 'max' => 20],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已被使用。', 'on' => self::SCENARIO_CREATE],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'filter' =>function($query){
                $query->andWhere(['not', ['id' => $this->id]]);
            },'message' => '该手机号码已被使用。', 'on' => self::SCENARIO_UPDATE],
            
            ['password', 'required', 'on' => self::SCENARIO_CREATE],
            ['password', 'string', 'min' => 6],
            
            
            [['role_id', 'sex'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role_id', 'default', 'value' => 1],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['username', 'email', 'password', 'mobile', 'role_id', 'group_id', 'fullname', 'sex'],
            'update' => ['email', 'password', 'mobile', 'group_id', 'fullname', 'sex'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '姓名',
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'fullname' => '真实姓名',
            'sex' => '性别',
            'role_id' => '角色',
            'group_id' => '会员组',
            'amount' => Yii::t('app', 'Amount'),
            'point' => Yii::t('app', 'Point'),
            'avatar' => Yii::t('app', 'Avatar'),
            'vip' => Yii::t('app', 'Vip'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
        ];
    }
    public function getTextStatus()
    {
        return [
            self::STATUS_INACTIVE => '<span class="text-danger">禁用</span>',
            self::STATUS_ACTIVE => '<span class="text-success">正常</span>',
        ];
    }
    
    public static function getUserAll($ids)
    {
        /* if (strpos(',', $ids) === false) {
            self::findOne($ids);
        } */
        $ids = explode(',', $ids);
        return self::find()->with('profile')->where(['in', 'id', $ids])->asArray()->all();
    }
    
    public static function getUserOne($id)
    {
        return self::find()->with('profile')->where(['id' => $id])->asArray()->one();
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }
        if (!$insert && !empty($this->password)) {
            $this->setPassword($this->password);
        }
        return parent::beforeSave($insert);
    }
}
