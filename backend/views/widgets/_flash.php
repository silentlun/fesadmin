<?php
/**
 * _flash.php
 * @author: allen
 * @date  2020年12月21日下午5:48:03
 * @copyright  Copyright igkcms
 */

if (Yii::$app->getSession()->hasFlash('success')) {
    $successTitle = addslashes( Yii::t('app', 'Success') );
    $info = addslashes( Yii::$app->getSession()->getFlash('success') );
    $str = <<<EOF
       toastr.options = {
          "closeButton": true,
          "debug": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "showDuration": "400",
          "hideDuration": "1000",
          "timeOut": "2000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
       };
       toastr.success("{$info}");
EOF;
    $this->registerJs($str);
}
if (Yii::$app->getSession()->hasFlash('error')) {
    $errorTitle = addslashes( Yii::t('app', 'Error') );
    $info = addslashes( Yii::$app->getSession()->getFlash('error') );
    $str = <<<EOF
       toastr.options = {
          "closeButton": true,
          "debug": false,
          "progressBar": true,
          "positionClass": "toast-top-center",
          "showDuration": "400",
          "hideDuration": "1000",
          "timeOut": "2000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
       };
       toastr.error("{$info}");
EOF;
    $this->registerJs($str);
}
?>