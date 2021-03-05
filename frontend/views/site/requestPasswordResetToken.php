<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '找回密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">
	<div class="row justify-content-center">
		<?php 
		switch ($ispostemail){
		    case 1:
		?>
		<div class="col-md-6">
			<?php $form = ActiveForm::begin(['id' => 'reset-form', 'options' => ['class' => 'login-form shadow-sm'],
			    'enableClientScript' => false,
			]); ?>
			    <div class="login-head">
			    	<h2><?= Html::encode($this->title) ?></h2>
			    	<p>请输入账号绑定的邮箱，我们将向您发送一封邮件，其中包含重设密码的说明。</p>
			    </div>
				<?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => '输入邮箱地址'])->label(false) ?>
				
				<?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-block', 'name' => 'reset-button']) ?>
			<?php ActiveForm::end(); ?>
			
		</div>
		<?php break;case 2:?>
		<div class="col-md-6">
			<div class="login-form shadow-sm">
			    <div class="login-head">
			    	<h2><?= Html::encode($this->title) ?></h2>
			    	<p>请输入账号绑定的邮箱，我们将向您发送一封邮件，其中包含重设密码的说明。</p>
			    </div>
			    <div class="alert alert-success" role="alert">
                  <h4 class="alert-heading"><i class="fa fa-check-circle"></i> 邮件发送成功!</h4>
                  <p>请登录您的邮箱，查看系统发送的密码找回邮件，按照提示进行密码重置操作。</p>
                </div>
			</div>
		</div>
		<?php break;case 3:?>
		<div class="col-md-6">
			<div class="login-form shadow-sm">
			    <div class="login-head">
			    	<h2><?= Html::encode($this->title) ?></h2>
			    	<p>请输入账号绑定的邮箱，我们将向您发送一封邮件，其中包含重设密码的说明。</p>
			    </div>
			    <div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> 邮件发送失败!</h4>
                  <p>抱歉，我们无法为提供的电子邮件地址重置密码。请检查您的邮箱接是否可以正常使用。</p>
                </div>
			</div>
		</div>
		<?php 
		break;
		}
		?>
	</div>
</div>
