<?php
/**
 * UploadForm.php
 * @author: allen
 * @date  2020年4月14日下午1:41:31
 * @copyright  Copyright igkcms
 */
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $dir;
    
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,gif,doc,docx,xls,xlsx,ppt,pptx,rar,zip,pdf'],
        ];
    }
    
    public function upload()
    {
        $basePath = Yii::getAlias('@uploads/');
        $savepath = $basePath.'uploads/'.$this->dir.'/';
        if ($this->validate()) {
            $this->imageFile->saveAs($savepath . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}