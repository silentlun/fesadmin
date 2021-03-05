<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\widgets\Bar;
use common\widgets\JsBlock;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Roles');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
    <div class="card-toolbar clearfix">
      <div class="toolbar-btn-action">
        <?= Bar::widget(['template' => '{create}']) ?>
      </div>
    </div>
    <div class="card-body">
    <?php Pjax::begin(); ?>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>角色名称</th>
              <th>描述</th>
              <th width="300">操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($model as $role) { ?>
            <tr>
              <td><?= Html::encode($role->name) ?></td>
              <td><?= Html::encode($role->description) ?></td>
              <td>
              <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#ajaxModal" href="<?=Url::to(['role/priv','name' => $role->name]) ?>" title="权限设置" data-pjax="0"><i class="fa fa-lock"></i> 权限设置</a>
              <a class="btn btn-success btn-xs" href="<?=Url::to(['role/update','name' => $role->name]) ?>" title="编辑" data-pjax="0"><i class="fa fa-edit"></i> 编辑</a> 
              <a class="btn btn-danger btn-xs" href="<?=Url::to(['role/delete','name' => $role->name]) ?>" title="删除" data-method="post" data-pjax="1" data-confirm="您确定要删除该数据吗？"><i class="fa fa-ban"></i> 删除</a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        
      </div>
      <?php Pjax::end(); ?>
    </div>
  </div>
<?php JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        $('#settingPriv').on('click', function () {
        	var url = $(this).attr('href');
        	$.ajax({
                url: url,
                success: function (data) {
                    var index = layer.open({
                        type: 1,
                        title: "设置权限",
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area: ['70%', '80%'],
                        content: data,
                    });
                    $("form[id=myform]").on('submit', function () {
                        var $form = $(this);
                        App.ajax({
                			url: $form.attr('action'),
                			type: "post",
                            data: $form.serialize(),
                			success: function (data) {
                				layer.close(index);
                				layer.msg('权限设置成功', {icon: 1});
                			}
                		});
                        
                        return false;
                    });
                   
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
    
</script>
<?php JsBlock::end() ?>
