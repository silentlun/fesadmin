<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $categoryModel->catname;

$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-title" style="background-image: url(<?=$bannerImg ?>);">
	<div class="container">
		<div class="content-box">
			<div class="title">
				<h1><?=$this->title ?></h1>
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
		<div class="row">
			<div class="col-md-12">
				<div class="single-content-full bg-white pt-5">
					<h1 class="article-title"><?= Html::encode($model->title) ?></h1>
				
					<div class="article-content">
						<?= $model->content ?>
				
				
					</div>
					<div class="d-flex justify-content-center">
					<div class="col-md-4"><?=Html::a('立即报名', ['contest/index'], ['class' => 'btn btn-primary btn-lg btn-block'])?></div>
					</div>
				</div>
	
	
			</div>
			
		</div>
	</div>
	
</section>
