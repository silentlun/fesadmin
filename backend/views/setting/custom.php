<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\JsBlock;
use yii\helpers\Url;
use common\models\Setting;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Configs');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = '自定义设置';
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card">
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a href="#">自定义设置</a></li>
  </ul>
  <?php $form = ActiveForm::begin([
        'id' => 'myform',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>
  <div class="tab-content">
    <div class="tab-pane fade in active">
      <?php foreach ($settings as $index => $setting):
      $deleteUrl = Url::to(['custom-delete', 'id' => $setting->id]);
      $editUrl = Url::to(['custom-update', 'id' => $setting->id]);
      $template = "{label}\n<div class=\"col-sm-6\">{input}\n{error}</div>\n{hint}<div class='col-sm-2'><p class='form-control-static'><a href='{$editUrl}' class='btn_edit' title='编辑' data-pjax=''><i style='margin-right: 10px;' class='fa fa-edit'></i></a> <a class='btn-delete' href='{$deleteUrl}' data-confirm='" . Yii::t('app', 'Are you sure you want to delete this item?') . "' title='' data-method='' data-pjax='1'><i class='fa fa-trash-o'></i></a></p></div>";
      if ($setting->field == Setting::INPUT_RADIO){
          echo $form->field($setting, "[$index]value", ['template' => $template])->label($setting->fieldlabel)->dropDownList(['0' => '否', '1' => '是']);
      } elseif ($setting->field == Setting::INPUT_TEXTAREA){
          echo $form->field($setting, "[$index]value", ['template' => $template])->label($setting->fieldlabel)->textarea(['rows' => 6]);
      } else {
          echo $form->field($setting, "[$index]value", ['template' => $template])->label($setting->fieldlabel)->textInput();
      }
      endforeach;
      ?>
    </div>
    <div class="form-group">
        <div class="col-sm-2 col-xs-6 col-sm-offset-2">
        <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <div class="col-sm-2 col-xs-6">
        <button type="button" class="btn btn-success btn-block" id="add"><?= Yii::t('app', 'Create Custom Field') ?></button>
        </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>
<?php JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        $('#add').click(function () {
            $.ajax({
                url: "<?=Url::toRoute("setting/custom-create")?>",
                success: function (data) {
                    layer.open({
                        type: 1,
                        title: "<?=Yii::t('app', 'Create')?>",
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area: ['70%', '80%'],
                        content: data,
                    });
                    $("form[name=custom]").on('submit', function () {
                        var $form = $(this);
                        $.ajax({
                            url: $form.attr('action'),
                            type: "post",
                            data: $form.serialize(),
                            beforeSend: function () {
                                layer.load(2);
                            },
                            success: function (data) {
                                location.href = "<?=Url::toRoute(['custom'])?>";
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            	layer.alert(jqXHR.responseJSON.message, {icon: 2});
                            },
                            complete: function () {
                                layer.closeAll("loading");
                            }
                        });
                        return false;
                    });
                    $("select#options-input_type").on('change', onCheckCanTypeInValue).trigger('change');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("ajax错误," + textStatus + ' : ' + errorThrown);
                },
                complete: function (XMLHttpRequest, textStatus) {
                }
            });
            return false;
        })
        $("a.btn_edit").click(function () {
            var name = $(this).parents("div.form-group").children("label").html();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    layer.open({
                        type: 1,
                        title: '<?=Yii::t('app', 'Update')?> ' + name,
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area: ['70%', '80%'],
                        content: data,
                    });
                    $("form[name=custom]").on('submit', function () {
                        var $form = $(this);
                        $.ajax({
                            url: $form.attr('action'),
                            type: "post",
                            data: $form.serialize(),
                            beforeSend: function () {
                                layer.load(2);
                            },
                            success: function (data) {
                                location.href = "<?=Url::toRoute(['custom'])?>";
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                layer.alert(jqXHR.responseJSON.message, {icon: 2});
                            },
                            complete: function () {
                                layer.closeAll("loading");
                            }
                        });
                        return false;
                    });
                    $("select#options-input_type").on('change', onCheckCanTypeInValue).trigger('change');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("ajax错误," + textStatus + ' : ' + errorThrown);
                },
                complete: function (XMLHttpRequest, textStatus) {
                }
            });
            return false;
        })
    });

    function onCheckCanTypeInValue() {
        var type = $(this).val();
        var restrictTypeTips = '<?=Yii::t('app', 'Type restrict, please type in after create')?>';
        var input = $("form[name=custom] input#options-value");
        if(type != <?=Setting::INPUT_INPUT?> && type != <?=Setting::INPUT_TEXTAREA?>){
            if( input.val() == restrictTypeTips ){
                input.val(input.attr('oldValue'));
            }else{
                input.attr('oldValue', input.val());
            }
            input.val(restrictTypeTips).attr('disabled', true);
        }else{
            if( input.val() == '<?=Yii::t('app', 'Type restrict, please type in after create')?>' ){
                input.val(input.attr('oldValue'));
            }else{
                input.attr('oldValue', input.val());
            }
            input.attr('disabled', false);
        }
    }
</script>
<?php JsBlock::end() ?>

