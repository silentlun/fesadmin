<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
/* @var $form yii\widgets\ActiveForm */
$roles = Yii::$app->getAuthManager()->getRoles();
$temp = [];
foreach (array_keys($roles) as $key){
    $temp[$key] = $key;
}
if ($model->id) {
    $model->roles = $model->getRolesNameString();
}
$itemsOptions = ['prompt'=>'==选择角色=='];
if(in_array( $model->getId(), Yii::$app->getBehavior('access')->superAdminUserIds)){
    $itemsOptions = ['prompt'=>'==选择角色==','disabled'=>'true'];
}

?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <div class="card-header">
    <h4><?= $subtitle ?></h4>
  </div>
  <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => $model->id]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'roles')->dropdownList($temp, $itemsOptions) ?>
    <?= $form->field($model, 'status')->radioList(['10'=>'正常','0'=>'禁用']) ?>


    <?= $form->defaultButtons() ?>

    <?php ActiveForm::end(); ?>
  </div>
</div>


