<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700',
        'statics/css/bootstrap.min.css',
        'statics/css/animate.min.css',
        'statics/css/font-awesome.min.css',
        'statics/css/style.min.css',
        'statics/css/style-responsive.min.css',
        'statics/plugins/toastr/toastr.min.css',
        'statics/plugins/datetimepicker/bootstrap-datetimepicker.min.css',
        'statics/css/fesadmin.css',
    ];
    public $js = [
        //"statics/js/jquery-2.2.4.min.js",
        "statics/js/bootstrap.min.js",
        "statics/js/jquery.slimscroll.min.js",
        "statics/plugins/layer/layer.js",
        "statics/plugins/datetimepicker/bootstrap-datetimepicker.min.js",
        'statics/plugins/toastr/toastr.min.js',
        'statics/js/fesadmin.js',
    ];
    public $depends = [
        BaseAsset::class,
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
