<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%position_data}}".
 *
 * @property int $id
 * @property int $catid
 * @property int $posid
 * @property int $thumb
 * @property string|null $data
 * @property int $created_at
 * @property int $listorder
 */
class PositionData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%position_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catid', 'posid', 'thumb', 'created_at', 'listorder'], 'integer'],
            [['data','module'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'ID'),
            'catid' => Yii::t('app', 'Catid'),
            'posid' => Yii::t('app', 'Posid'),
            'thumb' => Yii::t('app', 'Thumb'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'listorder' => Yii::t('app', 'Listorder'),
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['catid'=>'catid']);
    }
    
    /**
     * 获取内容
     */
    public static function getPositionData($catid, $id)
    {
        return self::find()->select('posid')->where(['catid'=>$catid, 'content_id'=>$id])->asArray()->all();
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        $posdata = self::getPositionData($this->catid, $this->content_id);
        $posids = $posdata ? ArrayHelper::getColumn($posdata, 'posid') : [];
        $model = \common\models\Content::findOne($this->content_id);
        $model->posids = $posids;
        $model->save();
    }
}
