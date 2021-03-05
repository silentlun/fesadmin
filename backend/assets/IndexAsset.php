<?php
/**
 * File Description 
 *
 * @author  Allen
 * @date  2019-12-20 下午4:43:22
 * @copyright  Copyright igkcms
 */
namespace backend\assets;

class IndexAsset extends \yii\web\AssetBundle
{

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700',
        'statics/css/bootstrap.min.css',
        'statics/css/animate.min.css',
        'statics/css/font-awesome.min.css',
        'statics/css/style.min.css',
        'statics/css/style-responsive.min.css',
        'statics/css/blue.css',
        'statics/css/fesadmin.css',
    ];

    public $js = [
        //"statics/js/jquery-2.2.4.min.js",
        "statics/js/jquery-migrate-1.1.0.min.js",
        "statics/js/jquery-ui.min.js",
        "statics/js/bootstrap.min.js",
        "statics/js/jquery.slimscroll.min.js",
        "statics/plugins/layer/layer.js",
        "statics/js/apps.min.js",
        "statics/js/pace.min.js"
    ];

    public $depends = [
        BaseAsset::class,
        'yii\web\YiiAsset',
    ];
}