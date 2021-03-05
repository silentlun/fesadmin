<?php
/**
 * treeview.php
 * @author: allen
 * @date  2020年4月24日下午5:45:20
 * @copyright  Copyright igkcms
 */
use backend\widgets\CategoryTree;
use yii\base\Widget;
use common\widgets\JsBlock;
/* @var $this yii\web\View */
$this->registerJsFile(
    '@web/statics/js/jquery.metisMenu.js',
    ['depends' => [\yii\web\YiiAsset::className()]]
    );


?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="ajaxModalLabel">选择栏目</h4>
  </div>
  <div class="modal-body ajaxmodal-content">
    <ul class="nav category-tree" id="categoryTree">
		<?=CategoryTree::widget(['data'=>$categorys])?>
	</ul>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" id="categoryTreeBtn">保存</button>
  </div>



<?php JsBlock::begin()?>
<script>
	var catid,catname;
	$(function () {
		$('#categoryTree').metisMenu({ toggle: false });
		$(':radio').click(function(){
			catid = $(this).val();
			catname = $(this).attr('data-name');
        })
        $('#categoryTreeBtn').click(function(){
            $('#catname').val(catname);
            $('#catid').val(catid);
            $('#ajaxModal').modal('hide');
        })
    })
	var callbackdata = function(){
		var data={catid:catid,catname:catname};
		return data;
	}
</script>
<?php JsBlock::end()?>


