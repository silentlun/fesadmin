<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\helpers\Util;
use yii\captcha\Captcha;

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
					<div class="user-security d-flex justify-content-between align-items-center">
						<div class="d-flex align-items-center">
						<i class="iconfont icon-check security-success"></i>
						<div class="security-title">登录密码</div>
						</div>
						<div class="col flex-grow-1 security-text">互联网账号存在被盗风险，建议您定期更改密码以保护账户安全。</div>
						<div class="text-right"><?= Html::a('修改', ['member/changepwd'], ['class' => 'btn btn-link']) ?></div>
					</div>
					<div class="user-security d-flex justify-content-between align-items-center">
						<?php if (Yii::$app->user->identity->email){?>
						<div class="d-flex align-items-center">
						<i class="iconfont icon-check security-success"></i>
						<div class="security-title">绑定邮箱</div>
						</div>
						<div class="col flex-grow-1 security-text">您绑定的邮箱：<?=Util::encryptStr(Yii::$app->user->identity->email)?> 若已停用，请立即更换，避免账户被盗。</div>
						<div class="text-right"><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#emailModal">修改</button></div>
						<?php }else{?>
						<div class="d-flex align-items-center">
						<i class="iconfont icon-warnfill security-warn"></i>
						<div class="security-title">绑定邮箱</div>
						</div>
						<div class="col flex-grow-1 security-text">绑定后，可用于接收参会购票通知。</div>
						<div class="text-right"><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#emailModal">绑定</button></div>
						<?php }?>
						
					</div>
					<div class="user-security d-flex justify-content-between align-items-center">
						<?php if (Yii::$app->user->identity->mobile){?>
						<div class="d-flex align-items-center">
						<i class="iconfont icon-check security-success"></i>
						<div class="security-title">绑定手机</div>
						</div>
						<div class="col flex-grow-1 security-text">您绑定的手机：<?=Util::encryptStr(Yii::$app->user->identity->mobile)?> 若已停用，请立即更换，避免账户被盗。</div>
						<div class="text-right"><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#mobileModal">修改</button></div>
						<?php }else{?>
						<div class="d-flex align-items-center">
						<i class="iconfont icon-warnfill security-warn"></i>
						<div class="security-title">绑定手机</div>
						</div>
						<div class="col flex-grow-1 security-text">绑定后，可用于验证码快捷登录，快速找回登录密码。</div>
						<div class="text-right"><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#mobileModal">绑定</button></div>
						<?php }?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="emailModalLabel">绑定邮箱</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $form = ActiveForm::begin(['id' => 'form-email', 'enableClientScript' => false,]); ?>
      <div class="modal-body">
        <input type="hidden" name="act" value="email">
          <?= $form->field($emailModel, 'email') ?>
          <div class="form-group required">
            <label for="message-text" class="col-form-label control-label">验证码</label>
            <div class="row">
              <div class="col-6"><?= Html::activeInput('text', $emailModel, 'verifyCode', ['class' => 'form-control']) ?></div>
              <div class="col-6"><button type="button" class="btn btn-light" id="sendVerifyEmail">发送验证码</button></div>
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">确定</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mobileModal" tabindex="-1" role="dialog" aria-labelledby="mobileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mobileModalLabel">绑定手机</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $form = ActiveForm::begin(['id' => 'form-mobile', 'enableClientScript' => false,]); ?>
      <div class="modal-body">
        <input type="hidden" name="act" value="mobile">
          <?= $form->field($mobileModel, 'mobile') ?>
          <?= $form->field($mobileModel, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-6">{input}</div><div class="col-6">{image}</div></div>',
                ]) ?>
          
          <div class="form-group required">
            <label for="message-text" class="col-form-label control-label">验证码</label>
            <div class="row">
              <div class="col-6"><?= Html::activeInput('text', $mobileModel, 'smsCode', ['class' => 'form-control']) ?></div>
              <div class="col-6"><button type="button" class="btn btn-light" id="sendVerifyMobile">发送验证码</button></div>
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">确定</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>