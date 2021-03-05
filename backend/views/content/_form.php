<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use common\models\Category;
use common\models\Position;
use yii\helpers\ArrayHelper;
use common\helpers\Constants;
use common\helpers\Util;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $form yii\widgets\ActiveForm */
/* $treeObj = new Tree(Category::getCategory());
$treeObj->nbsp = '  ';
$categorys = $treeObj->getTree(0, 'catname'); */
$categorys = Category::getCategory();
$positions = Position::getPosition('content');
//print_r($positions);exit;

$model->status = $model->status ? $model->status : 99;
$model->created_at = is_numeric($model->created_at) ? date('Y-m-d H:i:s',$model->created_at) : date('Y-m-d H:i:s');
//$model->posids = [1,2];
$posids = [];
if ($model->posid && !is_array($model->posid)) {
    $model->posid = explode(',', $model->posid);
}
if ($model->islink) {
    $model->linkurl = $model->url;
    $inputdisabled = false;
} else {
    $inputdisabled = true;
}
if ($model->isNewRecord) {
    $model->catid = Yii::$app->request->get('catid');
}

$baseTemplate = "{label}\n<div class=\"col-sm-10\">{input}\n{error}</div>\n{hint}";
$optionTemplate = "{label}\n<div class=\"col-sm-12\">{input}\n{error}</div>\n{hint}";
$editorTemplate = "{label}\n<div class=\"col-sm-10\">{input}\n{error}\n<div class=\"alert alert-warning no-margins form-inline\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"100\" size=\"3\" class=\"form-control input-sm\">字符至内容摘要
<label><input type='checkbox' name='auto_thumb' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"form-control input-sm\">张图片作为标题图片</div></div>";
?>
<?= $this->render('/widgets/_page-heading') ?>

<div class="row">
  <?php $form = ActiveForm::begin([
			  'fieldConfig' => [
			      'template' => $baseTemplate,
				  'labelOptions' => ['class' => 'col-sm-2 control-label'],              
			  ],
			  'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
  ]); ?>
  <div class="col-md-9">
    <div class="card">
      <ul class="nav nav-tabs page-tabs">
        <li class="active"><a>基本信息</a></li>
      </ul>
      <div class="card-body p-m">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'copyfrom')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
        <?= $form->field($model, 'content', ['template' => $editorTemplate])->widget('common\widgets\ueditor\Ueditor',[
			'options'=>[
				'initialFrameWidth' => '100%',
				'initialFrameHeight' => 400
			]
		]) ?>
		<?= $form->field($model, 'posid')->checkboxList(ArrayHelper::map($positions, 'posid', 'name')) ?>
		<div class="form-group field-content-keywords">
        <label class="col-sm-2 control-label" for="content-keywords">转向链接</label>
        <div class="col-sm-10">
        <div class="input-group">
            	<?= Html::activeInput('text', $model, 'linkurl', ['class' => 'form-control', 'id' => 'linkurl', 'disabled' => $inputdisabled]) ?>
                  <span class="input-group-addon">
                    <?= Html::activeCheckbox($model, 'islink', ['onclick' => 'ruselinkurl();', 'id' => 'islink']);?>
                  </span>
                </div>
        </div>
        
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <ul class="nav nav-tabs page-tabs">
        <li class="active"><a>属性</a></li>
      </ul>
      <div class="card-body p-m">
        <label>栏目分类</label>
        <?= $form->field($model, 'catid',['template' => $optionTemplate])->widget('backend\widgets\CategorySelect',['categorys'=>$categorys])->label(false) ?>
        
        <label>缩略图</label>
        <?= $form->field($model, 'thumb',['template' => $optionTemplate])->widget('common\widgets\webuploader\Webuploader',['config'=>['fileSingleSizeLimit'=>Yii::$app->config->site_upload_maxsize,'acceptExtensions'=>Yii::$app->config->site_upload_allowext]])->label(false) ?>
        <label>发布日期</label>
        <?= $form->field($model, 'created_at',['template' => $optionTemplate])->dateInput()->label(false) ?>
        <label>内容页模板</label>
        <?= $form->field($model, 'template',['template' => $optionTemplate])->dropdownList(Util::showTemplate('show'),['prompt'=>'选择模板'])->label(false);?>
        
        <label>状态</label>
        <div class="form-horizontal">
          <?= $form->field($model, 'status',['template' => $optionTemplate])->radioList(Constants::getContentStatus())->label(false) ?>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


