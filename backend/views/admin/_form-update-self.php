<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
    <?php $form = ActiveForm::begin([
        'id' => 'myform',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-4\">{input}</div>\n<div class=\"col-md-6\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-2 control-label'],
        ],
    ]); ?>
    <div class="form-group field-admin-username">
    <label class="col-md-2 control-label" for="admin-username">用户名</label>
    <div class="col-md-4"><p class="form-control-static"><?=$model->username; ?></p></div>
    </div>

    <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => 512]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 512])->label('新密码') ?>
    <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 512]) ?>


    <div class="form-group">
        <div class="col-md-3 col-md-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>


