<?php

use yii\helpers\Html;
use frontend\widgets\ListView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

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
<section class="blog-grid content">
	<div class="container">
		<div class="row">
			<div class="col-md-3 service-sidebar">
				<div class="categories-widget">
					<div class="widget-title"><h4>栏目导航</h4></div>
					<ul class="categories-list clearfix">
						<li><a href="/gallery"<?php if($categoryModel->id == 4) echo ' class="current"';?>>全部作品</a></li>
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
					<h4 class="head-title"><?=$this->title ?></h4>
				</div>
				<?= ListView::widget([
        		    'id' => 'fdlist',
                    'dataProvider' => $dataProvider,
        		    //'options' => ['class' => 'row clearfix'],
        		    'itemOptions' => [
        		        'tag' => 'div',
        		        'class' => 'col-md-4 gallery-block'
        		    ],
        		    'itemView' => '_item-gallery',
        		    'layout' => '<div class="row clearfix">{items}</div><div class="d-flex justify-content-center">{pager}</div>',
        		    'pager' => [
        		        'maxButtonCount' => 10,
        		        'nextPageLabel' => '下一页',
        		        'prevPageLabel' => '上一页',
        		    ],
                ]) ?>
	
	
			</div>
			
		</div>
	</div>
	
</section>