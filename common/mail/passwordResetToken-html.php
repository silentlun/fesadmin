<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>您好！ <?= Html::encode($user->username) ?>,</p>

    <p>您正在找回易智瑞杯竞赛网账号密码，请点击以下链接重设密码：</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    
    <p>如不是您本人操作，请忽略！</p>
</div>
