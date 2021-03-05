<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use yii\widgets\Pjax;
use common\widgets\JsBlock;
use common\models\Category;
use common\helpers\Tree;
use yii\helpers\Url;
use backend\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = $this->title.Yii::t('app', 'List');

?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="row-sm">
  <div class="col-md-2">
    <?= $this->render('/widgets/_categorys') ?>
  </div>
  <div class="col-md-10">
    <div class="full-height-scroll white-bg border-left">
      
      <div class="card">
        <div class="card-toolbar"></div>
        <div class="card-body">
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-md-10\">{input}{error}</div>",
                'labelOptions' => ['class' => 'col-md-1 control-label'],
            ]
        ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
			'options'=>[
				'initialFrameWidth' => '100%',
				'initialFrameHeight' => 400
			]
		]) ?>


    <?= $form->defaultButtons() ?>

    <?php ActiveForm::end(); ?>
        </div>
      </div>
      
    </div>
  </div>

</div>
