<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Configs');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = '邮箱设置';
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a href="#">邮箱设置</a></li>
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
      <?= $form->field($model, 'smtp_host')->textInput() ?>
      <?= $form->field($model, 'smtp_username')->textInput() ?>
      <?= $form->field($model, 'smtp_password')->textInput() ?>
      <?= $form->field($model, 'smtp_port')->textInput() ?>
      <?= $form->field($model, 'smtp_emcryption')->textInput() ?>
      <?= $form->field($model, 'smtp_nickname')->textInput() ?>
    </div>
    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


