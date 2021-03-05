<?php

use yii\helpers\Html;
use common\widgets\JsBlock;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Content */

?>
<div class="row" style="margin-top: 10px;">
  <?php foreach($thumbs as $thumb) {
  ?>
  <div class="col-xs-12 col-sm-3">
    <div class="thumbnail">
      <?= Html::img($thumb['thumb_url']) ?>
      <div class="caption">
        <span class="btn btn-danger btn-xs pull-right" style="margin-top: 0px;cursor: pointer;" onclick="thumb_delete('<?= urlencode($thumb['thumb_filepath'])?>',this)"><i class="fa fa-close"></i> 删除</span>
        <h3 style="margin-bottom: 0px;"><?= $thumb['width']?> X <?= $thumb['height']?></h3>
        
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php JsBlock::begin() ?>
<script>

    function thumb_delete(filepath, obj) {
    	layer.confirm('<?=Yii::t('app', 'Are you sure you want to delete this data?') ?>', {icon: 3, title:'提示'}, function(index){
    		App.ajax({
                url: '<?=Url::toRoute(['attachment/thumbdelete'])?>',
                type: 'post',
                data: {filepath:filepath},
                success: function (data) {
                	if(data.code == 200){
                		$(obj).parent().parent().fadeOut("slow");
                	}
                }
            });
    		layer.close(index);
    	});
    	
        return false;
    }
    function thumb_delete1(filepath, obj) {
    	layer.confirm('<?=Yii::t('app', 'Are you sure you want to delete this data?') ?>', {icon: 3, title:'提示'}, function(index){
    		$.ajax({
                url: '<?=Url::toRoute(['attachment/thumbdelete'])?>',
                type: 'post',
                data: {filepath:filepath},
                beforeSend: function () {
    			    layer.load(2);
    			},
                success: function (data) {
                	layer.closeAll('loading');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                	layer.alert(XMLHttpRequest.responseText, {icon: 2})
                },
                complete: function (XMLHttpRequest, textStatus) {
                	layer.closeAll('loading');
                }
            });
  		});
    	
        return false;
    }
</script>
<?php JsBlock::end() ?>
