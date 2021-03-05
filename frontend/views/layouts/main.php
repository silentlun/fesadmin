<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use common\models\Link;
use common\models\Message;

AppAsset::register($this);
$this->title = $this->title ? $this->title.' - ' : '';
$session = Yii::$app->session;
$session->remove('messageCount');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= Html::encode($this->title.Yii::$app->config->site_title) ?></title>
    <meta name="keywords" content="<?= Html::encode(Yii::$app->config->site_keywords) ?>">
    <meta name="description" content="<?= Html::encode(Yii::$app->config->site_description) ?>">
    <?php $this->registerCsrfMetaTags() ?>
    
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-expand-md navbar-dark header" id="homeheader">
  <div class="container">
  <a class="navbar-brand" href="/"><img class="header-logo" src="/statics/images/logo.png" alt=""></a>
  
  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbars">
    <?php 
	echo \frontend\widgets\Menu::widget([
	    'options' => ['class' => 'mr-auto'],
	]);
	?>
    <?php if (Yii::$app->user->isGuest):?>
    <div class="navbar-user">
	  <a class="btn btn-info btn-sm my-2 my-sm-0 mr-2 px-3" href="<?= Url::toRoute(['site/login']) ?>"> 登录 </a>
      <a class="btn btn-outline-info btn-sm my-2 my-sm-0 px-3" href="<?= Url::toRoute(['site/signup']) ?>"> 注册 </a>
	</div>
	<?php else:
	$messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'status' => 0, 'delete_at' => 0])->count();
	$session->set('messageCount', $messageCount);
	?>
	<div class="navbar-user dropdown">
	  <a class="dropdown-toggle" href="<?= Url::toRoute(['member/index']) ?>" role="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <svg class="user-icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="81" height="81"><path d="M1e-5 512.077A511.923 511.923.0 1 0 511.92301.0 511.974 511.974.0 0 0 1e-5 512.077z" fill="#fff" p-id="1349"/><path d="M887.49001 857.89c-13.697-71.82-139.895-140.459-253.165-177.96-5.54-1.846-40.014-17.339-18.417-82.798 56.43-57.815 99.214-150.924 99.214-242.597.0-140.82-93.827-214.742-202.891-214.742s-202.635 73.82-202.635 214.742c0 91.98 42.784 185.45 99.317 243.162 22.059 57.712-17.34 79.207-25.65 82.08-107.73 38.834-232.903 107.73-246.702 177.96a511.307 511.307.0 1 1 887.49-346.635 507.87 507.87.0 0 1-136.56 346.788" fill="#b8d4ff"/></svg><span class="user-name"><?=Yii::$app->user->identity->username;?></span>
	  </a>
	  <div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="userMenu">
	    <a class="dropdown-item" href="<?= Url::toRoute(['member/index']) ?>">个人中心</a>
	    <a class="dropdown-item" href="<?= Url::toRoute(['member/contest']) ?>">我的组队</a>
	    <a class="dropdown-item" href="<?= Url::toRoute(['member/message']) ?>">站内消息 <?php if ($messageCount) echo Html::tag('span', $messageCount, ['class' => 'badge badge-danger rounded-circle'])?></a>
		<div class="dropdown-divider"></div>
	    <a class="dropdown-item logout" href="<?= Url::toRoute(['site/logout']) ?>">退出</a>
	  </div>
	</div>
    <form class="form-inline my-2 my-lg-0">
      
    </form>
    <?php endif;?>
  </div>
  </div>
</nav>

<?= $content ?>

<footer class="footer">
	<div class="container py-4">
		<div class="row">
			<div class="col-md-3">
				<a href="/"><img id="logo-footer" class="footer-logo" src="/statics/images/logo.png" alt=""></a>
			</div>
			<div class="col-md-9">
				<div class="heading-footer">
					<h5>友情链接</h5>
				</div>
				<div class="row footer-links">
				<?php 
				$dependency = new \yii\caching\DbDependency(['sql'=>'SELECT MAX(updated_at) FROM link']);
				$links = Yii::$app->cache->getOrSet('footer-links', function () {
				    return Link::find()->where(['status' => Link::STATUS_ACTIVE])->orderBy('sort ASC,id ASC')->asArray()->all();
				}, '', $dependency);
				foreach ($links as $r) {
				    echo Html::a($r['title'], $r['url'], ['target' => '_blank']);
				}
				?>
					<!-- <a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a>
					<a href="#" target="_blank">友情链接</a> -->
				</div>
			</div>

		</div>
	</div>
	<div class="copyright">
        <div class="container">&copy; <?= date('Y') ?>  Copyright All By 易智瑞信息技术有限公司  &nbsp;&nbsp;<a href="http://www.beian.miit.gov.cn/" target="_blank"><?= Yii::$app->config->site_icp ?></a>&nbsp;&nbsp;<a
							 href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=11010502041406" target="_blank">京公网安备11010502041406号</a></div>
    </div>
</footer>


<?php $this->endBody() ?>
<?= $this->render('_flash') ?>
<?= Yii::$app->config->site_statics_script ?>
</body>
</html>
<?php $this->endPage() ?>
