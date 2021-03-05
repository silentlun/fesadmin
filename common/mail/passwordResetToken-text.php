<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
您好！ <?= $user->username ?>,

您正在找回易智瑞杯竞赛网账号密码，请点击以下链接重设密码：

<?= $resetLink ?>

如不是您本人操作，请忽略！
