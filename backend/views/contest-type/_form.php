<?php

use backend\widgets\ActiveForm;
use common\helpers\Constants;

/* @var $this yii\web\View */
/* @var $model common\models\ContestType */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a><?= $this->params['subtitle'] ?></a></li>
  </ul>
  <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>
    
    <?= $form->field($model, 'status')->radioList(Constants::getShowHideItems()) ?>


    <?= $form->defaultButtons() ?>

    <?php ActiveForm::end(); ?>
  </div>
</div>
