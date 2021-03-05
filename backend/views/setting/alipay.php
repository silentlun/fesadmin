<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alipay');

$this->params['breadcrumbs'][] = Yii::t('app', 'Expands');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <?php $form = ActiveForm::begin([
        'id' => 'form-setting',
        'options' => ['class' => 'form-horizontal none-loading'],
      'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-6\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>
  <ul class="nav nav-tabs page-tabs">
      <li class="active"><a href="#pc" role="tab" data-toggle="tab">网站&APP支付</a></li>
    </ul>
  <div class="tab-content">
    <div class="tab-pane fade in active" id="pc">
    <?= $form->field($model, 'alipay_appId')->textInput() ?>
    <?= $form->field($model, 'alipay_rsaPrivateKey')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'alipay_rsaPublicKey')->textarea(['rows' => 6]) ?>
    </div>
    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


