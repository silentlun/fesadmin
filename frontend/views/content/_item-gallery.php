<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Util;
?>
<div class="news-block-one">
		<div class="inner-box">
			<figure class="image-box"><a href="<?= Url::toRoute(['content/view', 'id' => $model->id]) ?>"><?= Html::img(Util::loadThumb($model->thumb), ['alt' => $model->title]) ?></a></figure>
			<div class="lower-content">
				<h3 class="ellipsis-2"><a href="<?= Url::toRoute(['content/view', 'id' => $model->id]) ?>"><?= $model->title ?></a></h3>
				<hr>
				<div class="d-flex justify-content-between align-items-center">
					<span class="post-date"><i class="fa fa-calendar"></i> <?= date('Y-m-d', $model->created_at) ?></span>
					<a href="<?= Url::toRoute(['content/view', 'id' => $model->id]) ?>" class="link"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
		</div>
	</div>


