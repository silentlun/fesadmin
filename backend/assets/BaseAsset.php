<?php
namespace backend\assets;
/**
 * BaseAsset.php
 * @author: allen
 * @date  2021年2月18日下午1:00:13
 * @copyright  Copyright igkcms
 */
use yii\web\AssetBundle;

class BaseAsset extends AssetBundle
{
    public $js = [
        "statics/js/jquery-2.2.4.min.js",
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}