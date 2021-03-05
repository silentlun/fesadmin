<?php
use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create User');
$this->params['subtitle'] = Yii::t('app', 'Create User');
?>

<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a><?= $this->params['subtitle'] ?></a></li>
  </ul>
  <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_id')->radioList([1 => '学生', 2 => '老师']) ?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => '真实姓名']) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sex')->dropdownList(['保密' => '保密', '男' => '男', '女' => '女']);?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    


    <?= $form->defaultButtons() ?>

    <?php ActiveForm::end(); ?>
  </div>
</div>

