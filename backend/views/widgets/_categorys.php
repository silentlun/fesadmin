<?php
/**
* categorys
*
* @author  Allen
* @date  2021-1-1 下午17:32:00
* @copyright  Copyright igkcms
*/
use yii\helpers\Html;
use common\widgets\JsBlock;
use common\models\Category;
use yii\helpers\Url;
use backend\widgets\CategoryTree;

$this->registerCssFile("@web/statics/plugins/jquery-treeview/css/jquery.treeview.css",['depends'=>['backend\assets\AppAsset']]);
$this->registerJsFile("@web/statics/plugins/jquery-treeview/js/jquery.treeview.js",['depends'=>['backend\assets\AppAsset']]);
$CAT = $categorys = [];
$categorys = Category::getCategory();

?>
<style type="text/css">
.filetree * { white-space: nowrap; }
.filetree span.folder, .filetree span.file {
	display: auto;
	padding: 1px 0 1px 16px;
}
.filetree .active{color:#007BFF;font-weight: 600}
</style>
<div class="cat-menu card">
  <h4 class="card-header">栏目导航</h4>
  <div class="card-body cat-menubody">
    <div id="treecontrol"><span style="display:none"> <a href="#"></a> <a href="#"></a> </span> <a href="#"><img src="/statics/plugins/jquery-treeview/images/minus.gif" /> <img src="/statics/plugins/jquery-treeview/images/application_side_expand.png" /> 展开/收缩</a> </div>
        <ul class="filetree  treeview" style="display:none">
          <li class="collapsable">
            <div class="hitarea collapsable-hitarea"></div>
            <span><img src="/statics/plugins/jquery-treeview/images/box-exclaim.gif" width="15" height="14">&nbsp;<a href='#' target='right'>审核内容</a></span></li>
        </ul>
        <ul class="filetree  treeview">
          <li><span class="folder"><a href="<?php echo Url::toRoute('content/index');?>" data-pjax="1">全部</a></span></li>
        </ul>
        <?php 
        echo CategoryTree::widget([
            'data' => $categorys,
        ]);
        ?>
        
  </div>   
        
</div>
<?php JsBlock::begin()?>
<script>
$(document).ready(function(){
    $("#category_tree").treeview({
			control: "#treecontrol",
			persist: "cookie",
			cookieId: "treeview-black"
	});
    $(".filetree").on('click','a',function(e){
        $('.filetree-item').removeClass('active');
        $(this).addClass('active');
    });
});
</script>
<?php JsBlock::end()?>

