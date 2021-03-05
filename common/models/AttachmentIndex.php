<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%attachment_index}}".
 *
 * @property int $id
 * @property string $keyid
 * @property int $aid
 */
class AttachmentIndex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attachment_index}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyid'], 'required'],
            [['aid'], 'integer'],
            [['keyid'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'keyid' => Yii::t('app', 'Keyid'),
            'aid' => Yii::t('app', 'Aid'),
        ];
    }
}
