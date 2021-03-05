<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'login-form shadow'],'enableClientScript' => false,]); ?>
			    <div class="login-head">
			    	<h2><?=$this->title?></h2>
			    </div>
				<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '输入邮箱或手机号']) ?>
				<?= $form->field($model, 'password')->passwordInput(['placeholder' => '输入密码']) ?>
				<div class="row justify-content-between mb-3">
					<div class="col align-self-center">
						<div class="custom-control custom-checkbox mr-sm-2">
							<?= Html::activeCheckbox($model, 'rememberMe', ['class' => 'custom-control-input', 'label' => false])?>
							<label class="custom-control-label" for="customControlAutosizing">记住登录状态</label>
						</div>
					</div>
					<div class="col align-self-center text-right">
						<?= Html::a('忘记密码？', ['site/request-password-reset']) ?>
					</div>
				</div>
				<?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
				<p class="mt-4 text-center">还没账号？ 点击立即<?= Html::a('注册', ['site/signup'], ['class' => 'text-primary']) ?></p>
			<?php ActiveForm::end(); ?>
			
		</div>
	</div>
</div>
