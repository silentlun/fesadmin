<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'options' => ['class' => 'login-form shadow-sm'],
			    'enableClientScript' => false,
			]); ?>
			    <div class="login-head">
			    	<h2><?= Html::encode($this->title) ?></h2>
			    	<p>请填写新的账号密码，重置成功后请使用新密码登录。</p>
			    </div>
				<?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => '字母、数字或者英文符号，最短6位，区分大小写']) ?>
				
				<div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-block', 'name' => 'reset-button']) ?>
                </div>
				
			<?php ActiveForm::end(); ?>
			
		</div>
	</div>
</div>

