<?php
/**
 * Setting.php
 * @author: allen
 * @date  2020年4月13日下午2:38:52
 * @copyright  Copyright igkcms
 */
namespace common\models;

use Yii;
use common\helpers\FileDependencyHelper;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $value
 * @property string $field
 */
class Setting extends \yii\db\ActiveRecord
{
    const TYPE_SYSTEM = 0;
    const TYPE_CUSTOM = 1;
    const INPUT_INPUT = 'input';
    const INPUT_TEXTAREA = 'textarea';
    const INPUT_RADIO = 'radio';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['name'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['field', 'fieldlabel'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [
                ['name'],
                'match',
                'pattern' => '/^[a-zA-Z][0-9_]*/',
                'message' => Yii::t('app', 'Must begin with alphabet and can only includes alphabet,_,and number')
            ],
            [['value'], 'default', 'value' => ''],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'field' => Yii::t('app', 'Field'),
            'fieldlabel' => Yii::t('app', 'Field Label'),
        ];
    }
    
    /**
     * @return array
     */
    public function getNames()
    {
        return array_keys($this->attributeLabels());
    }
    
    /**
     * 填充配置信息
     *
     */
    public function getSetting()
    {
        $names = $this->getNames();
        foreach ($names as $name) {
            $model = self::findOne(['name' => $name]);
            if ($model != null) {
                $this->$name = $model->value;
            } else {
                $this->name = '';
            }
        }
    }
    
    
    /**
     * 写入配置信息到数据库
     *
     * @return bool
     */
    public function setSetting()
    {
        $names = $this->getNames();
        foreach ($names as $name) {
            $model = self::findOne(['name' => $name]);
            if ($model != null) {
                $value = $this->$name;
                $value === null && $value = '';
                $model->value = $value;
                $result = $model->save(false);
            } else {
                $model = new Setting();
                $model->name = $name;
                $model->value = $this->$name;
                $result = $model->save(false);
            }
            if ($result == false) {
                return false;
            }
        }
        return true;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        $object = Yii::createObject([
            'class' => FileDependencyHelper::className(),
            'rootDir' => '@backend/runtime/cache/file_dependency/',
            'fileName' => 'setting.txt'
        ]);
        $object->updateFile();
        parent::afterSave($insert, $changedAttributes);
    }
}
