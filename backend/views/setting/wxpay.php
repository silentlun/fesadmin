<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Wxpay');
$this->params['breadcrumbs'][] = Yii::t('app', 'Modules');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a href="#jsapi" role="tab" data-toggle="tab">JSAPI支付</a></li>
    <li><a href="#h5" role="tab" data-toggle="tab">H5支付</a></li>
    <li><a href="#app" role="tab" data-toggle="tab">APP支付</a></li>
  </ul>
  <?php $form = ActiveForm::begin([
        'id' => 'form-setting',
        'options' => ['class' => 'form-horizontal none-loading'],
      'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-6\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>
  
  <div class="tab-content">
    <div class="tab-pane fade in active" id="jsapi">
    <?= $form->field($model, 'wxpay_jsapi_appId')->textInput() ?>
    <?= $form->field($model, 'wxpay_jsapi_mchId')->textInput() ?>
    <?= $form->field($model, 'wxpay_jsapi_key')->textInput() ?>
    <?= $form->field($model, 'wxpay_jsapi_appSecret')->textInput() ?>
    </div>
    <div class="tab-pane fade" id="h5">
    <?= $form->field($model, 'wxpay_h5_appId')->textInput() ?>
    <?= $form->field($model, 'wxpay_h5_mchId')->textInput() ?>
    <?= $form->field($model, 'wxpay_h5_key')->textInput() ?>
    <?= $form->field($model, 'wxpay_h5_appSecret')->textInput() ?>
    </div>
    <div class="tab-pane fade" id="app">
    <?= $form->field($model, 'wxpay_app_appId')->textInput() ?>
    <?= $form->field($model, 'wxpay_app_mchId')->textInput() ?>
    <?= $form->field($model, 'wxpay_app_key')->textInput() ?>
    <?= $form->field($model, 'wxpay_app_appSecret')->textInput() ?>
    </div>
    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


