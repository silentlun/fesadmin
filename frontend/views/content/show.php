<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $categoryModel->catname, 'url' => ['index', 'catdir' => $categoryModel->catdir]];
$this->params['breadcrumbs'][] = '详情';
\yii\web\YiiAsset::register($this);
?>
<section class="page-title" style="background-image: url(<?=$bannerImg ?>);">
	<div class="container">
		<div class="content-box">
			<div class="title">
				<h2><?= Html::encode($categoryModel->catname) ?></h2>
			</div>
			<?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			    'options' => ['class' => 'bread-crumb clearfix'],
            ]) ?>
		</div>
	</div>
</section>

		
		<section class="content1">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="single-content-full bg-white pt-5">
							<h1 class="article-title"><?= Html::encode($this->title) ?></h1>
							<div class="article-date"><i class="fa fa-calendar"></i> <?= date('Y-m-d', $model->created_at) ?></div>
						
							<div class="article-content">
								<?= $model->content ?>
						
						
							</div>
						</div>
						
					</div>
				</div>
				<div class="row ps-navigation mb-5">
					<div class="col">
					<span><i class="fa fa-long-arrow-left"></i> 上一篇</span>
					<a href="<?= $previousPage['url'] ?>"><?= $previousPage['title'] ?></a>
					</div>
					<div class="col text-right">
					<span>下一篇 <i class="fa fa-long-arrow-right"></i></span>
					<a href="<?= $nextPage['url'] ?>"><?= $nextPage['title'] ?></a>
					</div>
				</div>
			</div>
		
		</section>
