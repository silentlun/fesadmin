<?php
use yii\helpers\Url;

$this->title = '个人中心';
?>
<div class="container my-5">
			<div class="row">
				<div class="col-md-3">
					<?= $this->render('_left') ?>

				</div>
				<div class="col-md-9">
					<div class="card">
						<div class="card-body">
							<div class="headline d-flex justify-content-between">
								<h4 class="head-title">个人信息</h4>
								<a href="<?= Url::toRoute(['member/profile']) ?>" class="head-more">修改</a>
							</div>
							<div class="user-info row pt-3">
								<div class="col-md-12 mb-3">姓名：<?=Yii::$app->user->identity->username;?></div>
								<div class="col-md-12 mb-3">性别：<?=Yii::$app->user->identity->sex;?></div>
								<div class="col-md-12 mb-3">邮箱：<?=Yii::$app->user->identity->email ? Yii::$app->user->identity->email : '<span class="text-muted">未填写</span>';?></div>
								<div class="col-md-12 mb-3">手机：<?=Yii::$app->user->identity->mobile ? Yii::$app->user->identity->mobile : '<span class="text-muted">未填写</span>';?></div>
								<div class="col-md-12 mb-3">地区：<?=$profile->province;?> - <?=$profile->city;?> - <?=$profile->town;?></div>
								<?php if (Yii::$app->user->identity->role_id == 1):?>
								<div class="col-md-12 mb-3">学校：<?=$profile->school;?></div>
								<div class="col-md-12 mb-3">学院：<?=$profile->college;?></div>
								<div class="col-md-12 mb-3">专业：<?=$profile->profession;?></div>
								<div class="col-md-12 mb-3">班级：<?=$profile->class;?></div>
								<?php else:?>
								<div class="col-md-12 mb-3">公司：<?=$profile->company;?></div>
								<div class="col-md-12 mb-3">职务：<?=$profile->teaching;?></div>
								<?php endif;?>
								<div class="col-md-12 mb-3">地址：<?=$profile->address;?></div>
								<div class="col-md-12 mb-3">邮编：<?=$profile->postcode;?></div>
								<div class="col-md-12 mb-3">注册时间：<?=date('Y-m-d',Yii::$app->user->identity->created_at);?></div>

							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>