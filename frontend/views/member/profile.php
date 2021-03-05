<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\widgets\JsBlock;

$this->title = '修改资料';
?>
<div class="container my-5">
	<div class="row">
		<div class="col-md-3">
		<?= $this->render('_left') ?>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="headline d-flex justify-content-between">
						<h4 class="head-title">修改资料</h4>
					</div>
					<div class="mt-4">
					<div class="text-center mb-3 d-none">
                    	<div class="user-face mb-2">
                    		<img src="http://app.taibo.cn/phpsso_server/uploadfile/avatar/1/1/1/90x90.jpg?t=1599109205" onerror="this.src='http://app.taibo.cn/statics/images/default_user.png'">
                    	</div>
                    	<a href="<?=Url::toRoute(['member/avatar'])?>" class="btn btn-warning btn-sm">点击更换头像</a>
                    </div>
					<?php $form = ActiveForm::begin(['id' => 'form-profile', 'enableClientScript' => false,]); ?>

                    <?= $form->field($user, 'username') ?>
                    <?= $form->field($user, 'sex')->dropdownList(['保密' => '保密', '男' => '男', '女' => '女']);?>
                    <?= $form->field($user, 'mobile')->textInput(['placeholder' => '手机号码']) ?>
					<?= $form->field($user, 'email')->textInput(['placeholder' => '邮箱地址']) ?>
                    <div class="form-group required">
                    <label class="control-label">所在地区</label>
                    <div class="row" id="profileCitySelect">
                      <div class="col"><?= $form->field($profile, 'province')->dropdownList([],['prompt'=>'请选择','class' => 'form-control prov'])->label(false);?></div>
                      <div class="col"><?= $form->field($profile, 'city')->dropdownList([],['prompt'=>'请选择','class' => 'form-control city'])->label(false);?></div>
                    <div class="col"><?= $form->field($profile, 'town')->dropdownList([],['prompt'=>'请选择','class' => 'form-control dist'])->label(false);?></div>
                    </div>
                    
                    </div>
                    <?php if ($user->role_id == 1){?>
    				<?= $form->field($profile, 'school')->textInput(['placeholder' => Yii::t('app', 'School')]) ?>
    				<?= $form->field($profile, 'college')->textInput(['placeholder' => Yii::t('app', 'College')]) ?>
    				<?= $form->field($profile, 'profession')->textInput(['placeholder' => Yii::t('app', 'Profession')]) ?>
    				<?= $form->field($profile, 'class')->textInput(['placeholder' => Yii::t('app', 'Class')]) ?>
    				<?php }else{?>
    				<?= $form->field($profile, 'company')->textInput(['placeholder' => Yii::t('app', 'Company')]) ?>
    				<?= $form->field($profile, 'teaching')->textInput(['placeholder' => Yii::t('app', 'Teaching')]) ?>
    				<?php }?>
    				<?= $form->field($profile, 'address')->textInput(['placeholder' => Yii::t('app', 'Address')]) ?>
    				<?= $form->field($profile, 'postcode')->textInput(['placeholder' => Yii::t('app', 'Postcode')]) ?>
                
                    <div class="form-group d-flex justify-content-center">
                        <div class="col-md-3"><?= Html::submitButton('确认修改', ['class' => 'btn btn-primary btn-block']) ?></div>
                    </div>
                <?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php JsBlock::begin()?>
<script>
$("#profileCitySelect").citySelect({
	nodata:"none",
	required:false,
	prov:"<?= $profile->province?>",
	city:"<?= $profile->city?>",
	dist:"<?= $profile->town?>"
});
</script>
<?php JsBlock::end()?>