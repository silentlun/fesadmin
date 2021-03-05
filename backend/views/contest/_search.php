<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'action' => ['index', 'eventid' => Yii::$app->request->get('eventid')],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1,
        'class' => 'lister-search'
    ],
]); ?>

<div class="item">
	<label class="control-label">状态:</label>
	<div class="field">
		<?= Html::activeDropDownList($model, 'status', $model::getLabelStatus(), ['class' => 'form-control','prompt'=>'全部']) ?>
	</div>
</div>
<div class="item">
	<label class="control-label">参赛组别:</label>
	<div class="field">
		<?= Html::activeDropDownList($model, 'type_id', $model::getTypeList(), ['class' => 'form-control','prompt'=>'全部']) ?>
	</div>
</div>
<div class="item">
	<label class="control-label">序号:</label>
	<div class="field">
		<?= Html::activeInput('text', $model, 'id', ['class' => 'form-control', 'placeholder' => '序号ID']) ?>
	</div>
</div>
<div class="item">
	<label class="control-label">作品名称:</label>
	<div class="field">
		<?= Html::activeInput('text', $model, 'title', ['class' => 'form-control', 'placeholder' => '作品名称']) ?>
	</div>
</div>

<div class="item">
<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> 搜索</button>
</div> 
<?php ActiveForm::end(); ?>

