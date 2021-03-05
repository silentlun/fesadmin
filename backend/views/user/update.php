<?php
use yii\helpers\Html;
use backend\widgets\ActiveForm;
use common\widgets\JsBlock;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
$this->registerJsFile(
    '@web/statics/js/jquery.cityselect.js',
    ['depends' => [\yii\web\YiiAsset::className()]]
    );
$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update User');
$this->params['subtitle'] = Yii::t('app', 'Update User');
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a><?= $this->params['subtitle'] ?></a></li>
  </ul>
  <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['placeholder' => '不修改密码请留空']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <div class="form-group required">
    <label class="col-sm-2 control-label">所在地区</label>
    <div class="col-sm-8">
      <div class="row" id="profileCitySelect">
        <div class="col-xs-4"><?= Html::activeDropDownList($profile, 'province', [],['prompt'=>'请选择','class' => 'form-control prov']) ?></div>
        <div class="col-xs-4"><?= Html::activeDropDownList($profile, 'city', [],['prompt'=>'请选择','class' => 'form-control city']) ?></div>
        <div class="col-xs-4"><?= Html::activeDropDownList($profile, 'town', [],['prompt'=>'请选择','class' => 'form-control dist']) ?></div>
      </div>
      
      
    
    </div>
    
    </div>
    <?php if ($model->role_id == 1){?>
	<?= $form->field($profile, 'school')->textInput(['placeholder' => Yii::t('app', 'School')]) ?>
	<?= $form->field($profile, 'college')->textInput(['placeholder' => Yii::t('app', 'College')]) ?>
	<?= $form->field($profile, 'profession')->textInput(['placeholder' => Yii::t('app', 'Profession')]) ?>
	<?= $form->field($profile, 'class')->textInput(['placeholder' => Yii::t('app', 'Class')]) ?>
	<?php }else{?>
	<?= $form->field($profile, 'company')->textInput(['placeholder' => Yii::t('app', 'Company')]) ?>
	<?= $form->field($profile, 'teaching')->textInput(['placeholder' => Yii::t('app', 'Teaching')]) ?>
	<?php }?>
	<?= $form->field($profile, 'address')->textInput(['placeholder' => Yii::t('app', 'Address')]) ?>
	<?= $form->field($profile, 'postcode')->textInput(['placeholder' => Yii::t('app', 'Postcode')]) ?>


    <?= $form->defaultButtons() ?>

    <?php ActiveForm::end(); ?>
  </div>
</div>

<?php JsBlock::begin()?>
<script>
$("#profileCitySelect").citySelect({
	nodata:"none",
	required:false,
	prov:"<?= $profile->province?>",
	city:"<?= $profile->city?>",
	dist:"<?= $profile->town?>"
});
</script>
<?php JsBlock::end()?>
