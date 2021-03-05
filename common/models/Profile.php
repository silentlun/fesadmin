<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member_detail}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $school
 * @property string $college
 * @property string $profession
 * @property string $class
 * @property string $company
 * @property string $teaching
 * @property string $address
 * @property string $postcode
 */
class Profile extends \yii\db\ActiveRecord
{
    const SCENARIO_STUDENT = 'student';
    const SCENARIO_TEACHER = 'teacher';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member_profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province', 'city', 'town', 'address', 'postcode'], 'required'],
            [['user_id'], 'integer'],
            [['school', 'college', 'profession', 'class'], 'required', 'on' => self::SCENARIO_STUDENT],
            [['company', 'teaching'], 'required', 'on' => self::SCENARIO_TEACHER],
            [['province', 'city', 'town', 'school', 'college', 'profession', 'class', 'company', 'teaching', 'address', 'postcode'], 'trim'],
            [['province', 'city', 'town'], 'string', 'max' => 50],
            [['school', 'college', 'profession', 'class', 'company', 'teaching'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 20],
            [['province', 'city', 'town', 'school', 'college', 'profession', 'class', 'company', 'teaching', 'address', 'postcode'], 'default', 'value' => ''],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'school' => Yii::t('app', 'School'),
            'college' => Yii::t('app', 'College'),
            'profession' => Yii::t('app', 'Profession'),
            'class' => Yii::t('app', 'Class'),
            'company' => Yii::t('app', 'Company'),
            'teaching' => Yii::t('app', 'Teaching'),
            'address' => Yii::t('app', 'Address'),
            'postcode' => Yii::t('app', 'Postcode'),
        ];
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_STUDENT] = ['province', 'city', 'town', 'school', 'college', 'profession', 'class', 'address', 'postcode'];
        $scenarios[self::SCENARIO_TEACHER] = ['province', 'city', 'town', 'company', 'teaching', 'address', 'postcode'];
        return $scenarios;
    }
}
