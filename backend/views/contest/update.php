<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="ajaxModalLabel">修改参赛组</h4>
  </div>
  <?php $form = ActiveForm::begin([
      'id' => 'verify-from',
      'options' => ['class' => 'form-horizontal'],
      'enableAjaxValidation' =>true,
      'enableClientValidation' => false,
      'validationUrl' => Url::toRoute(['update', 'id' => $model->id]),
      'fieldConfig' => [
          'template' => "<label class='col-sm-2'>{label}</label><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
      ],
      'fieldClass' => 'backend\widgets\ActiveField',
  ]); ?>
  <div class="modal-body">
    <?= $form->field($model, 'type_id')->dropdownList($model::getTypeList(),['prompt'=>'选择分组']) ?>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">保存</button>
  </div>
  <?php ActiveForm::end(); ?>




