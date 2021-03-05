<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card no-borders">
  <div class="card-body">
    <?php $form = ActiveForm::begin(['options' => [
        'class' => '',
        'id' => 'myform',
        'name' => 'myform',
        'enctype' => 'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>


    <div class="form-group">
          <div class="col-sm-6">
            <?= Html::submitButton('上传文件', ['class' => 'btn btn-success btn-block']) ?>
          </div>
        </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
