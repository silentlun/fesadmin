<?php

use yii\helpers\Html;
use common\widgets\JsBlock;
use backend\widgets\Bar;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Attachments');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="card animated fadeInRight">
  <ul class="nav nav-tabs page-tabs">
    <li><a href="<?=Url::to(['attachment/index'])?>">数据库模式</a></li>
    <li class="active"><a href="<?=Url::to(['attachment/directory'])?>">目录模式</a></li>
  </ul>
  <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <a class="btn btn-primary m-r-5" data-toggle="modal" data-target="#ajaxModal" id="createdir" href="<?=Url::to(['attachment/create'])?>" title="创建"><i class="fa fa-plus"></i> 创建</a>
      </div>
    </div>
    <div class="card-body">
    	<table class="table table-hover">
        	<thead>
        		<tr>
        			<th>当前目录：<?php echo $local?></th>
        			<th></th>
        		</tr>
        	</thead>
        	<tbody>
        	<?php if ($dir !='' && $dir != '.'):?>
        		<tr>
        			<td><a href="<?=Url::to(['attachment/directory', 'dir' => stripslashes(dirname($dir))])?>"><i class="fa fa-folder text-warning"></i> 上一层目录</a></td>
        			<td></td>
        		</tr>
        		<?php endif;?>
        		<?php 
if(is_array($list)) {
	foreach($list as $v) {
	$filename = basename($v)
?>
        		<tr>
        			<?php if (is_dir($v)) {
        			    $dir = $dir ? $dir.'/' : '';
        			    echo '<td align="left"><i class="fa fa-folder text-warning"></i>  '.Html::a($filename, ['attachment/directory', 'dir' => $dir.$filename]).'</td><td width="15%"><a class="upload" href="javascript:;"  data-dir="'.$dir.$filename.'"><i class="fa fa-cloud-upload"></i> 上传文件</a> | '.Html::a('删除', ['attachment/delete-dir-file', 'path' => $dir.$filename], ['data-confirm' => '本操作会将目录下的所有文件删除，删除后无法恢复，确定要删除目录吗？']).'</td>';
} else {
    echo '<td align="left" ><i class="fa fa-file text-danger"></i> <a rel="'.$local.'/'.$filename.'">'.$filename.'</a></td><td width="15%"><a href="javascript:;" onclick="copyUrl(\''.Yii::$app->config->site_upload_url.urlencode($local).'/'.urlencode($filename).'\')">复制链接</a> | <a href="javascript:;" onclick="att_delete(this,\''.urlencode($filename).'\',\''.urlencode($local).'\')">删除</a> </td>';
}?>
        		</tr>
        		<?php 
	}
}
?>
        	</tbody>
        </table>
      
    </div>
  
</div>

<?php JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        $('.upload').click(function () {
            var dir = $(this).data('dir');
            $.ajax({
                url: "<?=Url::toRoute("attachment/update")?>",
                data:{dir:dir},
                success: function (data) {
                    layer.open({
                        type: 1,
                        title: "上传文件",
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area: ['500px', '300px'],
                        content: data,
                    });
                    $("form[name=custom]").on('submit', function () {
                    	var $form = $(this);
                        var form = new FormData(document.getElementById("myform"));
                        $.ajax({
                            url: $form.attr('action'),
                            type: "post",
                            data: form,
                            cache:false,
    						processData: false,
    						contentType: false,
                            beforeSend: function () {
                                layer.load(2);
                            },
                            success: function (data) {
                            	location.reload();
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


