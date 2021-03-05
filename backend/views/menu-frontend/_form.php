<?php

use backend\widgets\ActiveForm;
use common\helpers\Constants;

/* @var $this yii\web\View */
/* @var $model common\models\MenuFrontend */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a><?= $this->params['subtitle'] ?></a></li>
  </ul>
  <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parentid')->dropdownList($model::getMenuTree(),['prompt'=>'作为一级菜单']);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'target')->radioList(['_self' => '当前窗口', '_blank' => '新窗口']) ?>

    <?= $form->field($model, 'display')->radioList(Constants::getYesNoItems()) ?>

    <?= $form->field($model, 'sort')->textInput() ?>


    <?= $form->defaultButtons() ?>

    <?php ActiveForm::end(); ?>
  </div>
</div>
