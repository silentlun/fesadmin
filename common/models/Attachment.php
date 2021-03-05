<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property int $id
 * @property string $module
 * @property string $filename
 * @property string $filepath
 * @property int $filesize
 * @property string $fileext
 * @property int $isimage
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attachment}}';
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
            [['module', 'filename', 'filepath', 'fileext'], 'required'],
            [['filesize', 'isimage', 'status', 'created_at', 'updated_at'], 'integer'],
            [['module'], 'string', 'max' => 20],
            [['filename', 'filepath'], 'string', 'max' => 255],
            [['fileext'], 'string', 'max' => 15],
            [['status'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'module' => Yii::t('app', 'Module'),
            'filename' => Yii::t('app', 'Filename'),
            'filepath' => Yii::t('app', 'Filepath'),
            'filesize' => Yii::t('app', 'Filesize'),
            'fileext' => Yii::t('app', 'Fileext'),
            'isimage' => Yii::t('app', 'Isimage'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getFilesizeText()
    {
        if($this->filesize >= 1073741824) {
            $filesize = round($this->filesize / 1073741824 * 100) / 100 . ' GB';
        } elseif($this->filesize >= 1048576) {
            $filesize = round($this->filesize / 1048576 * 100) / 100 . ' MB';
        } elseif($this->filesize >= 1024) {
            $filesize = round($this->filesize / 1024 * 100) / 100 . ' KB';
        } else {
            $filesize = $this->filesize . ' Bytes';
        }
        return $filesize;
    }
    
    public static function apiUpdate($keyid){
        $att_json = Yii::$app->request->cookies->getValue('att_json','');
        if($att_json) {
            $att_cookie_arr = explode('||', $att_json);
            $att_cookie_arr = array_unique($att_cookie_arr);
        } else {
            return false;
        }
        foreach ($att_cookie_arr as $_att_c) $att[] = json_decode($_att_c,true);
        foreach ($att as $_v) {
            $attachment = self::findOne($_v['aid']);
            $attachment->status = 1;
            $attachment->update();
            $customer = new AttachmentIndex();
            $customer->keyid = $keyid;
            $customer->aid = "{$_v['aid']}";
            $customer->save();
        }
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('att_json');
        return true;
    }
    public static function apiDelete($keyid)
    {
        
        $infos = AttachmentIndex::find()->where(['keyid' => $keyid])->all();
        if ($infos) {
            foreach ($infos as $r){
                self::findOne($r['aid'])->delete();
            }
            AttachmentIndex::deleteAll(['keyid' => $keyid]);
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $image = Yii::getAlias('@uploads/') . $this->filepath;
        unlink($image);
        $thumbs = glob(dirname($image).'/*'.basename($image));
        if($thumbs) foreach($thumbs as $thumb) unlink($thumb);
        return parent::afterDelete();
    }
}
