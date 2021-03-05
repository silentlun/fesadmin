<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $mobile;
    public $verifyCode;
    public $fullname;
    public $type;
    public $sex;
    public $province;
    public $city;
    public $town;
    public $school;
    public $college;
    public $profession;
    public $class;
    public $company;
    public $teaching;
    public $address;
    public $postcode;
    
    const SCENARIO_STUDENT = 'student';
    const SCENARIO_TEACHER = 'teacher';


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/', 'message' => '姓名格式不正确'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该用户名已被使用。'],
            ['username', 'string', 'min' => 2, 'max' => 20],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该邮箱地址已被使用。'],
            
            ['mobile', 'trim'],
            ['mobile', 'required'],
            ['mobile', 'match', 'pattern' => '/^[1][3456789][0-9]{9}$/', 'message' => '手机号格式不正确'],
            ['mobile', 'string', 'max' => 20],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已被使用。'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            /* ['fullname', 'trim'],
            ['fullname', 'required'],
            ['fullname', 'string', 'min' => 2, 'max' => 20], */
            
            [['type', 'sex', 'province', 'city', 'town', 'address', 'postcode'], 'required'],
            [['school', 'college', 'profession', 'class'], 'required', 'on' => self::SCENARIO_STUDENT],
            [['company', 'teaching'], 'required', 'on' => self::SCENARIO_TEACHER],
            [['province', 'city', 'town', 'school', 'college', 'profession', 'class', 'company', 'teaching', 'address', 'postcode'], 'trim'],
            [['province', 'city'], 'string', 'max' => 50],
            [['school', 'college', 'profession', 'class', 'company', 'teaching'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 20],
            [['school', 'college', 'profession', 'class', 'company', 'teaching', 'address', 'postcode'], 'default', 'value' => ''],
            
            ['verifyCode', 'captcha'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => '姓名',
            'password' => '密码',
            'fullname' => Yii::t('app', 'Fullname'),
            'sex' => Yii::t('app', 'Sex'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'user_id' => Yii::t('app', 'User ID'),
            'school' => Yii::t('app', 'School'),
            'college' => Yii::t('app', 'College'),
            'profession' => Yii::t('app', 'Profession'),
            'class' => Yii::t('app', 'Class'),
            'company' => Yii::t('app', 'Company'),
            'teaching' => Yii::t('app', 'Teaching'),
            'address' => Yii::t('app', 'Address'),
            'postcode' => Yii::t('app', 'Postcode'),
            'province' => '省份',
            'city' => '城市',
            'town' => '区县',
        ];
    }
    
    public function scenarios()
    {
        return [
            self::SCENARIO_STUDENT => ['type', 'username', 'password', 'email', 'mobile', 'sex', 'province', 'city', 'town', 'school', 'college', 'profession', 'class', 'address', 'postcode'],
            self::SCENARIO_TEACHER => ['type', 'username', 'password', 'email', 'mobile', 'sex', 'province', 'city', 'town', 'company', 'teaching', 'address', 'postcode'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->role_id = $this->type;
        $user->group_id = 1;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->mobile = $this->mobile;
        //$user->fullname = $this->fullname;
        $user->sex = $this->sex;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        return $user->save() && $this->createProfile($user);

    }
    
    protected function createProfile($user)
    {
        $profile = new Profile();
        $profile->setAttributes($this->attributes, false);
        $profile->user_id = $user->id;
        if ($profile->save()) {
            Yii::$app->user->login($user, 0);
            return true;
        }
        return false;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
