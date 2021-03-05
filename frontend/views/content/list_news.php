<?php

use yii\helpers\Html;
use yii\widgets\ListView;
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
				<h1><?=Html::encode($categoryModel->catname)?></h1>
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
	    <?= ListView::widget([
		    'id' => 'newslist',
            'dataProvider' => $dataProvider,
		    //'options' => ['class' => 'row clearfix'],
		    'itemOptions' => [
		        'tag' => 'div',
		        'class' => 'col-md-4 news-block'
		    ],
		    'itemView' => '_item-news',
		    'layout' => '<div class="row clearfix">{items}</div><div class="d-flex justify-content-center">{pager}</div>',
		    'pager' => [
		        'maxButtonCount' => 10,
		        'nextPageLabel' => '下一页',
		        'prevPageLabel' => '上一页',
		    ],
        ]) ?>
		
	</div>
</section>

