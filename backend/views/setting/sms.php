<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '短信设置';
$this->params['breadcrumbs'][] = Yii::t('app', 'Modules');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a href="#">短信设置</a></li>
  </ul>
  <?php $form = ActiveForm::begin([
        'id' => 'myform',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-6\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>
  <div class="tab-content">
    <div class="tab-pane active" id="smtp">
      <?= $form->field($model, 'sms_access_keyId')->textInput() ?>
      <?= $form->field($model, 'sms_access_keySecret')->textInput() ?>
      <?= $form->field($model, 'sms_signName')->textInput() ?>
    </div>
    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


