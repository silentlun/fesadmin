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
use common\helpers\Tree;
use yii\helpers\Url;

$this->registerCssFile("@web/statics/plugins/jquery-treeview/css/jquery.treeview.css",['depends'=>['backend\assets\AppAsset']]);
$this->registerJsFile("@web/statics/plugins/jquery-treeview/js/jquery.treeview.js",['depends'=>['backend\assets\AppAsset']]);
$CAT = $categorys = [];
$CAT = Category::getCategory();
if (!empty($CAT)){
    foreach ($CAT as $r){
        if ($r['type'] == 0) {
            $r['icon_type'] = 'add';
            $r['add_icon'] = "";
            //$r['add_icon'] = "<a href='".Url::toRoute('content/create')."&catid={$r['id']}'><img src='statics/plugins/jquery-treeview/images/add_content.gif' alt='创建内容'></a> ";
        } else {
            $r['icon_type'] = 'file';
            $r['add_icon'] = '';
        }
        $r['add_class'] = 'filetree-item';
        if ($r['id'] == Yii::$app->request->get('catid')) $r['add_class'] = 'filetree-item active';
        $categorys[$r['id']] = $r;
    }
}
if(!empty($categorys)) {
    $liststrs = "<span class='\$icon_type'>\$add_icon<a href='".Url::toRoute('content/index')."?catid=\$id' class='\$add_class' data-pjax>\$catname</a></span>";
    $pagestrs = "<span class='\$icon_type'>\$add_icon<a href='".Url::toRoute('page/index')."?catid=\$id' class='\$add_class' data-pjax>\$catname</a></span>";
    $strs2 = "<span class='folder'>\$catname</span>";
    $treeObj = new Tree($categorys);
    $categorys = $treeObj->getViewTree(0,'category_tree',$liststrs,$strs2,$pagestrs);
} else {
    $categorys = Yii::t('app', 'please_add_category');
}
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
        <?php echo $categorys?>
        
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

