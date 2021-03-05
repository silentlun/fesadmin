<?php
/**
 * _flash.php
 * @author: allen
 * @date  2020年12月21日下午5:54:51
 * @copyright  Copyright igkcms
 */
if (Yii::$app->session->hasFlash('success')) {
    $info = addslashes( Yii::$app->session->getFlash('success') );
    $str = <<<EOF
        swal({text:"{$info}",icon:'success',buttons: false,timer: 2000,});
EOF;
    $this->registerJs($str);
}
if (Yii::$app->session->hasFlash('error')) {
    $info = addslashes( Yii::$app->session->getFlash('error') );
    $str = <<<EOF
        swal({text:"{$info}",icon:'error',buttons: false,timer: 2000,});
EOF;
    $this->registerJs($str);
}