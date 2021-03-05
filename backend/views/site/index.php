<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use backend\widgets\Menu;
use yii\helpers\Url;
use backend\assets\IndexAsset;

IndexAsset::register($this);
$this->title = Yii::t('app', 'Backend Manage System');
$identity = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" href="<?= Yii::$app->request->getHostInfo() ?>/favicon.ico" type="image/x-icon"/>
</head>
<body>
<?php $this->beginBody() ?>
<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="<?= Url::toRoute('site/index') ?>" class="navbar-brand"><span class="navbar-logo"></span> FesAdmin</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li class=""> <a href="<?= Yii::$app->config->site_url ?>" target='_blank'><i class="fa fa-internet-explorer"></i> 前台</a> </li>
                      <li class=""> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-refresh"></i> 缓存</a> 
                        <ul class="dropdown-menu animated fadeInLeft">
                      		<li class="arrow"></li>
                      		<li><a class="actionclear" href="<?= Url::toRoute('clear/frontend') ?>">清除前台</a></li>
                      		<li class="divider"></li>
                      		<li><a class="actionclear" href="<?= Url::toRoute('clear/backend') ?>">清除后台</a></li>
                      	</ul>
                      </li>
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<img src="statics/images/user-13.jpg" alt="" /> 
							<span class="hidden-xs"><?= $identity->username ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a class="J_menuItem" href="<?= Url::toRoute('admin/update-self') ?>">修改密码</a></li>
							<li class="divider"></li>
							<li><a data-method="post" href="<?= Url::toRoute('site/logout') ?>">退出登录</a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="image">
							<a href="javascript:;"><img src="statics/images/user-13.jpg" alt="" /></a>
						</div>
						<div class="info">
							<?= $identity->username ?>
							<small><i class="fa fa-circle text-success"></i> <?= $identity->getRolesNameString()?></small>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					<li class="nav-header">菜单导航</li>
					<?= Menu::widget() ?>
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		<div class="content">
			<iframe id="J_iframe" width="100%" height="100%" src="<?= Url::toRoute('site/main') ?>" frameborder="0" seamless></iframe>
		  
		</div>
		<!-- end #content -->
		
	</div>

<?php $this->endBody() ?>
</body>
<script>
$(document).ready(function() {
	App.init();
});
    function reloadIframe() {
        var current_iframe = $("iframe:visible");
        current_iframe[0].contentWindow.location.reload();
        return false;
    }
    if (window.top !== window.self) {
        window.top.location = window.location;
    }
    $(function(){$(".J_menuItem").on('click',function(){var url=$(this).attr('href');$("#J_iframe").attr('src',url);$(".has-sub").removeClass('active');$(this).parent().parent().parent().addClass('active');$(".J_menuItem").parent().removeClass('active');$(this).parent().addClass('active');return false;});});
</script>
</html>
<?php $this->endPage() ?>