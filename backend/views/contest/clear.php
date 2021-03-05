<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="ajaxModalLabel">确定要清空数据吗？</h4>
  </div>
  <?php $form = ActiveForm::begin([
      'id' => 'verify-from',
      'options' => ['class' => 'form-horizontal'],
      'enableAjaxValidation' =>true,
      'enableClientValidation' => false,
      'validationUrl' => Url::toRoute(['clear']),
      'fieldConfig' => [
          'template' => "<label class='col-sm-2'>{label}</label><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
      ],
      'fieldClass' => 'backend\widgets\ActiveField',
  ]); ?>
  <div class="modal-body">
    <p class="text-danger m-b-30">警告：该操作会删除所有报名数据和上传的附件，删除后将无法恢复，请谨慎操作！</p>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-xs-6">{input}</div><div class="col-xs-6">{image}</div></div>',
		    'options' => [
		        'placeholder' => '验证码',
		    ],
        ]) ?>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">确定</button>
  </div>
  <?php ActiveForm::end(); ?>
