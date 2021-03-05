<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Configs');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = '基本设置';
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a href="#web" role="tab" data-toggle="tab">网站设置</a></li>
    <li><a href="#attr" role="tab" data-toggle="tab">附件设置</a></li>
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
    <div class="tab-pane fade in active" id="web">
      <?= $form->field($model, 'site_title')->textInput() ?>
      <?= $form->field($model, 'site_url')->textInput() ?>
      <?= $form->field($model, 'site_keywords')->textInput() ?>
      <?= $form->field($model, 'site_description')->textInput() ?>
      <?= $form->field($model, 'site_icp')->textInput() ?>
      <?= $form->field($model, 'site_statics_script')->textarea(['rows' => '6']) ?>
      <?= $form->field($model, 'site_status')->radioList(['1'=>'正常','0'=>'关闭']) ?>
    </div>
    <div class="tab-pane fade" id="attr">
      <?= $form->field($model, 'site_upload_url')->textInput() ?>
      <?= $form->field($model, 'site_upload_allowext')->textInput() ?>
      <?= $form->field($model, 'site_upload_maxsize',['template'=>"{label}\n<div class=\"col-sm-6\"><div class=\"row\"><div class=\"col-sm-6\">\n{input}\n{error}</div><div class=\"col-sm-6 form-control-static\">{hint}</div></div></div>"])->textInput()->hint('KB') ?>
    </div>
    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


