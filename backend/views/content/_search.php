<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model backend\models\ContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

	<?php $form = ActiveForm::begin([
	        'id' => 'myform',
	        'options' => ['class' => 'pull-right search-bar','data' => ['pjax' => true]],
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="input-group">
              <?= Html::activeInput('text', $model, 'title', ['class' => 'form-control','placeholder' => '输入关键词']) ?>
              <div class="input-group-btn"><button type="submit" class="btn btn-success">搜索</button></div>
            </div>
	<?php ActiveForm::end(); ?>



