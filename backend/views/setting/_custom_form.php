<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card">
  <div class="card-body">
    <?php $form = ActiveForm::begin([
        'id' => 'custom',
        'options' => ['class' => 'form-horizontal','name' => 'custom'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-8\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'field')->dropDownList(['input'=>'单行文本','textarea'=>'多行文本','radio'=>'单选']) ?>
    <?= $form->field($model, 'fieldlabel')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>

