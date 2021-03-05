<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%contest}}".
 *
 * @property int $id
 * @property string $num
 * @property string $name
 * @property int $type_id
 * @property int $user_id
 * @property string $student
 * @property string $teacher
 * @property string $file
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Contest extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_REJECT = 2;
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_FRONTEND_UPDATE = 'frontend_update';
    
    public $upfile;
    public $types;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contest}}';
    }
    
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
            [['type_id', 'user_id', 'status'], 'integer'],
            ['title', 'trim'],
            [['title', 'type_id'], 'required'],
            [['title', 'file'], 'string', 'max' => 255],
            [['student', 'teacher'], 'string', 'max' => 100],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['upfile', 'file', 'skipOnEmpty' => false, 'except' => [self::SCENARIO_FRONTEND_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'title' => '作品名称',
            'type_id' => '参赛组别',
            'user_id' => '创建人',
            'student' => '组员',
            'teacher' => '导师',
            'file' => '附件',
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['type_id'];
        $scenarios[self::SCENARIO_FRONTEND_UPDATE] = ['type_id', 'title', 'file', 'student', 'teacher', 'status', 'upfile'];
        return $scenarios;
    }
    
    public static function getLabelStatus()
    {
        return [
            self::STATUS_REJECT => '审核拒绝',
            self::STATUS_INACTIVE => '等待审核',
            self::STATUS_ACTIVE => '审核通过',
        ];
    }
    public static function getTextStatus()
    {
        return [
            self::STATUS_REJECT => '<span class="text-muted">审核拒绝</span>',
            self::STATUS_INACTIVE => '<span class="text-danger">等待审核</span>',
            self::STATUS_ACTIVE => '<span class="text-success">审核通过</span>',
        ];
    }
    
    public function getType()
    {
        return $this->hasOne(ContestType::className(), ['id' => 'type_id']);
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getStudents()
    {
        if ($this->student) {
            $student = explode(',', $this->student);
            $query = User::find()->select(['username'])->where(['in', 'id', $student])->asArray()->all();
            if ($query) {
                $data = [];
                foreach ($query as $r) {
                    $data[] = $r['username'];
                }
                return implode('<br>', $data);
            } else {
                return '';
            }
            //return User::find()->select(['fullname'])->where(['in', 'id', $student])->asArray()->all();
        } else {
            return '';
        }
    }
    
    public function getTeachers()
    {
        if ($this->teacher) {
            $teacher = explode(',', $this->teacher);
            $query = User::find()->select(['username'])->where(['in', 'id', $teacher])->asArray()->all();
            if ($query) {
                $data = [];
                foreach ($query as $r) {
                    $data[] = $r['username'];
                }
                return implode('<br>', $data);
            } else {
                return '';
            }
            //return User::find()->where(['in', 'id', $teacher])->asArray()->all();
        } else {
            return '';
        }
    }
    
    public static function getIds($user_id)
    {
        $createUser = self::find()->select('id')->where(['user_id' => $user_id])->asArray()->all();
        $studentUser = self::find()->select('id')->where("find_in_set($user_id, student)")->asArray()->all();
        $teacherUser = self::find()->select('id')->where("find_in_set($user_id, teacher)")->asArray()->all();
        
        $createids = ArrayHelper::getColumn($createUser, 'id');
        $studentids = ArrayHelper::getColumn($studentUser, 'id');
        $teacherids = ArrayHelper::getColumn($teacherUser, 'id');
        return implode(',', ArrayHelper::merge($createids, $studentids, $teacherids));
    }
    
    public function upload()
    {
        $ext = $this->upfile->extension;
        $filename = $this->types->subname.$this->id.'.'.$ext;
        $basePath = Yii::getAlias('@uploads/');
        $savepath = $basePath.'contest/'.date('Y/');
        if (!file_exists($savepath)) {
            FileHelper::createDirectory($savepath);
        }
        $this->upfile->saveAs($savepath . $filename);
        $this->file = str_replace($basePath, '', $savepath . $filename);
        $this->save();
        return true;
    }
    
    public function edit(){
        $oldfile = $this->file;
        $ext = substr(strrchr($oldfile, '.'), 1);
        $oldname = basename($oldfile, ".".$ext);
        $newfile = str_replace($oldname, $this->type['subname'].$this->id, $oldfile);
        rename(Yii::getAlias('@uploads/').$oldfile, Yii::getAlias('@uploads/').$newfile);
        $this->file = $newfile;
        return $this->save();
    }
    
    public static function getTypeList()
    {
        return ContestType::getTypes();
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        FileHelper::unlink(Yii::getAlias('@uploads/').$this->file);
    }
}
