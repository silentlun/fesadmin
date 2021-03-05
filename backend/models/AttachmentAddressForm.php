<?php
/**
 * AttachmentAddressForm.php
 * @author: allen
 * @date  2020年6月18日上午11:22:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use Yii;
use yii\base\Model;

class AttachmentAddressForm extends Model
{
    public $old_attachment_path;
    
    public $new_attachment_path;
    
    public function rules()
    {
        return [
            [['old_attachment_path', 'new_attachment_path'], 'required'],
            [['old_attachment_path', 'new_attachment_path'], 'url']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'old_attachment_path' => Yii::t('app', 'Old Attachment Path'),
            'new_attachment_path' => Yii::t('app', 'New Attachment Path'),
        ];
    }
    
}