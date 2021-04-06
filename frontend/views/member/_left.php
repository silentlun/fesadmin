<?php
use yii\helpers\Url;
use yii\helpers\Html;

$messageCount = Yii::$app->params['messageCount'];
?>
<div class="card border-0">
	<div class="user-head mb-4">
		<div class="user-face"><svg class="user-icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="81" height="81"><path d="M1e-5 512.077A511.923 511.923.0 1 0 511.92301.0 511.974 511.974.0 0 0 1e-5 512.077z" fill="#fff" p-id="1349"/><path d="M887.49001 857.89c-13.697-71.82-139.895-140.459-253.165-177.96-5.54-1.846-40.014-17.339-18.417-82.798 56.43-57.815 99.214-150.924 99.214-242.597.0-140.82-93.827-214.742-202.891-214.742s-202.635 73.82-202.635 214.742c0 91.98 42.784 185.45 99.317 243.162 22.059 57.712-17.34 79.207-25.65 82.08-107.73 38.834-232.903 107.73-246.702 177.96a511.307 511.307.0 1 1 887.49-346.635 507.87 507.87.0 0 1-136.56 346.788" fill="#b8d4ff"/></svg></div>
		<h5 class="mt-2"> <?=Yii::$app->user->identity->username?></h5>

	</div>
	<div class="user-menu list-group my-3">
			<a href="<?=Url::toRoute(['member/index'])?>" class="list-group-item list-group-item-action<?=Yii::$app->controller->action->id == 'index' ? ' active' : ''?>"><i class="fa fa-home"></i> 个人主页</a>
			<a href="<?=Url::toRoute(['member/contest'])?>" class="list-group-item list-group-item-action<?=in_array(Yii::$app->controller->action->id,['contest', 'contest-team', 'contest-update']) ? ' active' : ''?>"><i class="fa fa-users"></i> 我的组队</a>
			<a href="<?=Url::toRoute(['member/message'])?>" class="list-group-item list-group-item-action<?=Yii::$app->controller->action->id == 'message' ? ' active' : ''?>"><i class="fa fa-envelope"></i> 站内消息  <?php if ($messageCount) echo Html::tag('span', $messageCount, ['class' => 'badge badge-danger rounded-circle'])?></a>
			<a href="<?=Url::toRoute(['member/profile'])?>" class="list-group-item list-group-item-action<?=Yii::$app->controller->action->id == 'profile' ? ' active' : ''?>"><i class="fa fa-cog"></i> 个人资料</a>
			<a href="<?=Url::toRoute(['member/changepwd'])?>" class="list-group-item list-group-item-action<?=Yii::$app->controller->action->id == 'changepwd' ? ' active' : ''?>"><i class="fa fa-lock"></i> 修改密码</a>
			<a href="<?=Url::toRoute(['site/logout'])?>" class="list-group-item list-group-item-action logout"><i class="fa fa-power-off"></i> 安全退出</a>
		</div>
</div>
		