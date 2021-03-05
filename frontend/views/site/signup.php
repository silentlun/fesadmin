<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = '注册账号';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
		   <?php if (Yii::$app->request->get('type')){?>
			<?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'signup-form shadow'],'enableClientScript' => false,]); ?>
			    <div class="login-head">
			    	<h2><?= Html::encode($this->title) ?></h2>
			    	<?php if ($model->type == 1){?>
			    	<p>账号类型：学生账号</p>
			    	<?php }else{?>
			    	<p>账号类型：老师账号</p>
			    	<?php }?>
			    </div>
				<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '真实姓名']) ?>
				<?= $form->field($model, 'password')->passwordInput(['placeholder' => '字母、数字或者英文符号，最短6位，区分大小写']) ?>
				<?= $form->field($model, 'sex')->dropdownList(['保密' => '保密', '男' => '男', '女' => '女']);?>
				<?= $form->field($model, 'mobile')->textInput(['placeholder' => '手机号码']) ?>
				<?= $form->field($model, 'email')->textInput(['placeholder' => '邮箱地址']) ?>
				<div class="form-group field-signupform-mobile required">
<label class="control-label" for="signupform-mobile">所在地区</label>
<div class="row" id="citySelect">
  <div class="col"><?= $form->field($model, 'province')->dropdownList([],['prompt'=>'请选择','class' => 'form-control prov'])->label(false);?></div>
  <div class="col"><?= $form->field($model, 'city')->dropdownList([],['prompt'=>'请选择','class' => 'form-control city'])->label(false);?></div>
<div class="col"><?= $form->field($model, 'town')->dropdownList([],['prompt'=>'请选择','class' => 'form-control dist'])->label(false);?></div>
</div>


<p class="help-block help-block-error"></p>
</div>
				<?php if ($model->type == 1){?>
				<?= $form->field($model, 'school')->textInput(['placeholder' => Yii::t('app', 'School')]) ?>
				<?= $form->field($model, 'college')->textInput(['placeholder' => Yii::t('app', 'College')]) ?>
				<?= $form->field($model, 'profession')->textInput(['placeholder' => Yii::t('app', 'Profession')]) ?>
				<?= $form->field($model, 'class')->textInput(['placeholder' => Yii::t('app', 'Class')]) ?>
				<?php }else{?>
				<?= $form->field($model, 'company')->textInput(['placeholder' => Yii::t('app', 'Company')]) ?>
				<?= $form->field($model, 'teaching')->textInput(['placeholder' => Yii::t('app', 'Teaching')]) ?>
				<?php }?>
				<?= $form->field($model, 'address')->textInput(['placeholder' => Yii::t('app', 'Address')]) ?>
				<?= $form->field($model, 'postcode')->textInput(['placeholder' => Yii::t('app', 'Postcode')]) ?>
				
				<?= $form->field($model, 'verifyCode')->label(false)->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-6">{input}</div><div class="col-6">{image}</div></div>',
				    'options' => [
				        'placeholder' => '验证码',
				    ],
                ]) ?>
				
				<?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'signup-button']) ?>
				<p class="mt-4 text-center">已经有一个帐号？ 点击立即<?= Html::a('登录', ['site/login'], ['class' => 'text-primary']) ?></p>
			<?php ActiveForm::end(); ?>
			<?php }else{?>
			<div class="signup-form shadow">
			    <div class="login-head">
			    	<h2>选择注册的账号类型</h2>
			    	<p>注册成功后账号类型将无法更改，请谨慎选择。</p>
			    </div>
			    <div class="form-group d-flex justify-content-center">
			    <a class="signup-type-item" href="<?=Url::to(['site/signup', 'type' => 1])?>">
			      <div class="d-flex">
                    <div class="d-flex align-self-center mr-3">
                      <span class="item-icon">
                        <i class="fa fa-user"></i>
                      </span>
                    </div>
                    <div class="align-self-center">
                      <h3>学生</h3>
                    </div>
                  </div>
			    </a>
			    <a class="signup-type-item" href="<?=Url::to(['site/signup', 'type' => 2])?>">
			      <div class="d-flex">
                    <div class="d-flex align-self-center mr-3">
                      <span class="item-icon">
                        <i class="fa fa-user-secret"></i>
                      </span>
                    </div>
                    <div class="align-self-center">
                      <h3>老师</h3>
                    </div>
                  </div>
			    </a>
			    </div>
		    </div>
		    <?php }?>
		</div>
	</div>
</div>