<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="ajaxModalLabel">创建目录</h4>
  </div>
  <?php $form = ActiveForm::begin(); ?>
  <div class="modal-body">
    <div class="form-group field-category-catname required">
<label class="col-sm-3 control-label">目录名称</label>
<div class="col-sm-8"><input type="text" class="form-control" name="dirname"><div class="help-block"></div></div>
</div>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">创建</button>
  </div>
  <?php ActiveForm::end(); ?>




