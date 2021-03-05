<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $categoryModel->catname, 'url' => ['index', 'catdir' => $categoryModel->catdir]];
$this->params['breadcrumbs'][] = '详情';

?>
<section class="page-title" style="background-image: url(/statics/images/page-title.jpg);">
	<div class="container">
		<div class="content-box">
			<div class="title">
				<h1><?=Html::encode($categoryModel->catname)?></h1>
			</div>
			<?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			    'options' => ['class' => 'bread-crumb clearfix'],
            ]) ?>
		</div>
	</div>
</section>
		
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="article">
					<h2><?= Html::encode($this->title) ?></h2>
					<div class="article-date my-3 text-right text-muted"><i class="fa fa-calendar"></i> <?= date('Y-m-d', $model->created_at) ?></div>
				
					<div class="article-content">
						<?= $model->content ?>
				
				
					</div>
				</div>
				
			</div>
			<div class="col-md-3">
						<div class="sidebar-widget">
							<h5 class="sub-headtitle"><span>最新新闻</span></h5>
							<ul class="list-unstyled hot-news">
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/domestic/244000067327.html" title="3000测绘人实名公开信呼吁注册测绘师制度不应取消"><span
										 class="badge badge-danger">1</span>
										<p>3000测绘人实名公开信呼吁注册测绘师制度不应取消</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/domestic/244000067212.html" title="国土空间规划师出炉，注册测绘师被调出《国家职业资格目录》"><span
										 class="badge badge-danger">2</span>
										<p>国土空间规划师出炉，注册测绘师被调出《国家职业资格目录》</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/enterprise/363000067220.html" title="专栏 | 十年角力，谷歌地图最终关闭出局"><span
										 class="badge badge-danger">3</span>
										<p>专栏 | 十年角力，谷歌地图最终关闭出局</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/domestic/244000067361.html" title="5000名注册规划师+4000名注册测绘师联名请愿保留注册准入制度"><span
										 class="badge badge-secondary">4</span>
										<p>5000名注册规划师+4000名注册测绘师联名请愿保留注册准入制度</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/enterprise/363000066935.html" title="邹庆忠任浪潮集团掌门，孙丕恕卸任后从政"><span
										 class="badge badge-secondary">5</span>
										<p>邹庆忠任浪潮集团掌门，孙丕恕卸任后从政</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/domestic/244000067411.html" title="曾任航天八院院长，朱芝松同志任上海市委常委"><span
										 class="badge badge-secondary">6</span>
										<p>曾任航天八院院长，朱芝松同志任上海市委常委</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/enterprise/363000067116.html" title="平安与华夏幸福的进与退"><span
										 class="badge badge-secondary">7</span>
										<p>平安与华夏幸福的进与退</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/startup/246000067161.html" title="军工资本或入局，航新科技筹划控制权变更并计划停牌"><span
										 class="badge badge-secondary">8</span>
										<p>军工资本或入局，航新科技筹划控制权变更并计划停牌</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/startup/246000067317.html" title="时空科技企业维智科技WAYZ宣布完成4000万美元的A+轮融资"><span
										 class="badge badge-secondary">9</span>
										<p>时空科技企业维智科技WAYZ宣布完成4000万美元的A+轮融资</p>
									</a>
								</li>
								<li class="hotitem">
									<a class="d-flex align-items-start" href="http://www.3snews.net/enterprise/363000067284.html" title="拼多多天才黑客疑被开除 因拒绝做黑客攻击业务"><span
										 class="badge badge-secondary">10</span>
										<p>拼多多天才黑客疑被开除 因拒绝做黑客攻击业务</p>
									</a>
								</li>
			
							</ul>
						</div>
						
					</div>
		</div>
	</div>

</section>
