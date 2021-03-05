<?php
/**
* Ueditor Asset
*
* @author  Allen
* @date  2020-4-2 上午11:50:07
* @copyright  Copyright igkcms
*/

namespace common\widgets\ueditor\assets;

use Yii;
use yii\web\AssetBundle;

class UeditorAsset extends AssetBundle {
    public $css = [

    ];
    
    public $js = [
        'ueditor.config.js',
        'ueditor.all.min.js',
    ];
    
    public $depends = [

    ];
    
    /**
     * 初始化：sourcePath赋值
     * @see \yii\web\AssetBundle::init()
     */
    public function init()
    {
        $this->sourcePath = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR . 'vendor';
    }
}
