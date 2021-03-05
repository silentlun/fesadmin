<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'statics/css/bootstrap.min.css',
        'statics/css/animate.min.css',
        'statics/css/font-awesome.min.css',
        'statics/css/owl.carousel.css',
        'statics/css/style.css',
    ];
    public $js = [
        "statics/js/bootstrap.min.js",
        "statics/js/vue.min.js",
        "statics/js/jquery-core-plugins.js",
        "statics/js/jquery.validate.min.js",
        "statics/js/jquery.cityselect.js",
        "statics/plugins/layer/layer.js",
        "statics/plugins/sweetalert.min.js",
        'statics/js/app.js',
    ];
    public $depends = [
        BaseAsset::class,
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
