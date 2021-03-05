<?php
namespace common\widgets\webuploader\assets;

use Yii;
use yii\web\AssetBundle;

class WebuploaderAsset extends AssetBundle{
    
    public $css = [
	   'css/webuploader.css',
    ];
    
    public $js = [
	   'js/webuploader.min.js',
	   'js/init.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
    
    public function init()
    {
        $this->sourcePath = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR . 'statics';
    }
}