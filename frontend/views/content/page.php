<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $model->title;

$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-title" style="background-image: url(<?=$bannerImg ?>);">
	<div class="container">
		<div class="content-box">
			<div class="title">
				<h1><?=$model->title ?></h1>
			</div>
			<?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			    'options' => ['class' => 'bread-crumb clearfix'],
            ]) ?>
		</div>
	</div>
</section>
<section class="blog-grid content">
	<div class="container">
		<div class="row">
			<div class="col-md-3 service-sidebar">
				<div class="categories-widget">
					<div class="widget-title"><h4>栏目导航</h4></div>
					<ul class="categories-list clearfix">
					    <?php 
					    foreach ($category as $cat){
					        $class = [];
					        if ($cat['id'] == $categoryModel->id){
					            $class['class'] = 'current';
					        }
					        echo '<li>'.Html::a($cat['catname'], ['content/index', 'catdir' => $cat['catdir']], $class).'</li>';
					    }
					    ?>
					    
					</ul>
				</div>
				
			</div>
			<div class="col-md-9">
				<div class="headline">
					<h4 class="head-title"><?=$model->title ?></h4>
				</div>
				<div class="article-content mt-4">
					<?=$model->content ?>
														
				</div>
	
	
			</div>
			
		</div>
	</div>
	
</section>
