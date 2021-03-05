<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Contest;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="ajaxModalLabel">审核</h4>
  </div>
  <?php $form = ActiveForm::begin([
      'id' => 'verify-from',
      'options' => ['class' => 'form-horizontal'],
      'enableAjaxValidation' =>true,
      'enableClientValidation' => false,
      'validationUrl' => Url::toRoute(['verify']),
      'fieldConfig' => [
          'template' => "<label class='col-sm-2'>{label}</label><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
      ],
      'fieldClass' => 'backend\widgets\ActiveField',
  ]); ?>
  <div class="modal-body">
    <?= $form->field($model, 'status')->radioList([Contest::STATUS_ACTIVE => '审核通过', Contest::STATUS_REJECT => '审核拒绝']) ?>
    <?= $form->field($model, 'content', ['template' => "<div id='verifyContent' style='display:none'><label class='col-sm-2'>{label}</label><div class='col-sm-10'>{input}\n{hint}\n{error}</div></div>"])->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">保存</button>
  </div>
  <?php ActiveForm::end(); ?>


<script>

$('input[name="ContestVerifyForm[status]"]').on('click', function() {
	if($("input[name='ContestVerifyForm[status]']:checked").val() == 2){
		$('#verifyContent').show();
	}else{
		$('#verifyContent').hide();
	}
});
</script>

