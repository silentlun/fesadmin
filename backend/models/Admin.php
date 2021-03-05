<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\ForbiddenHttpException;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    public $password;
    
    public $repassword;
    
    public $old_password;
    public $roles;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'roles'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['username'], 'match', 'pattern'=>'/^[a-z]\w*$/i'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password'], 'required','on'=>['login','create']],
            [['password', 'repassword', 'old_password'], 'required','on'=>['self-update']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['prev_login_ip', 'last_login_ip'], 'string', 'max' => 15],
            [['prev_login_time', 'last_login_time'], 'integer'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['username', 'password'],
            'create' => ['username', 'email', 'password', 'status', 'roles'],
            'update' => ['username', 'email', 'password', 'status', 'roles'],
            'self-update' => ['password', 'old_password', 'repassword'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password' => '密码',
            'email' => '邮箱',
            'role' => '角色',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'old_password' => '旧密码',
            'repassword' => '重复新密码',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    
    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }
    
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setPassword($this->password);
        }
        if (!$insert && !empty($this->password)) {
            $this->setPassword($this->password);
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if ($this->id == 1) {
            throw new ForbiddenHttpException(Yii::t('app', "Not allowed to delete {attribute}", ['attribute' => Yii::t('app', 'default super administrator admin')]));
        }
        return parent::beforeDelete();
    }
    
    /**
     * 添加角色
     */
    public function assignRole()
    {
        //实例化AuthManager类
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($this->roles);
        
        $auth->assign($role, $this->id);
        return true;
        
    }
    
    public function updateRole(){
        $auth = \Yii::$app->authManager;
        $auth->revokeAll($this->id);
        $role = $auth->getRole($this->roles);
        $auth->assign($role, $this->id);
        return true;
    }
    public function getRolesName()
    {
        if( in_array( $this->getId(), Yii::$app->getBehavior('access')->superAdminUserIds ) ){
            return [Yii::t('app', 'System Administrator')];
        }
        $role = array_keys( Yii::$app->authManager->getRolesByUser($this->getId()) );
        if( !isset( $role[0] ) ) return [];
        return $role;
    }
    
    public function getRolesNameString($glue=',')
    {
        $roles = $this->getRolesName();
        $str = '';
        foreach ($roles as $role){
            $str .= $role . $glue;
        }
        return rtrim($str, $glue);
    }
    
    /**
     * @inheritdoc
     */
    public function selfUpdate()
    {
        if ($this->password != '') {
            if ($this->old_password == '') {
                $this->addError('old_password', Yii::t('app', '{attribute} cannot be blank.', ['attribute' => Yii::t('app', 'Old Password')]));
                return false;
            }
            if (! $this->validatePassword($this->old_password)) {
                $this->addError('old_password', Yii::t('app', '{attribute} is incorrect.', ['attribute' => Yii::t('app', 'Old Password')]));
                return false;
            }
            if ($this->repassword != $this->password) {
                $this->addError('repassword', Yii::t('app', '{attribute} is incorrect.', ['attribute' => Yii::t('app', 'Repeat Password')]));
                return false;
            }
        }
        return $this->save();
    }
}
