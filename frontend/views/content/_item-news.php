<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Util;
?>

	<div class="news-block-one">
		<div class="inner-box">
			<figure class="image-box"><a href="<?= Url::toRoute(['content/view', 'id' => $model->id]) ?>"><?= Html::img(Util::loadThumb($model->thumb), ['alt' => $model->title]) ?></a></figure>
			<div class="lower-content">
				<div class="post-date mb-2"><i class="fa fa-calendar"></i> <?= date('Y-m-d', $model->created_at) ?></div>
				<h4 class="ellipsis-2"><a href="<?= Url::toRoute(['content/view', 'id' => $model->id]) ?>"><?= $model->title ?></a></h4>
				<p class="ellipsis-2"><?= $model->description ?></p>
				<div class="d-flex justify-content-between align-items-center read-button">
					<a href="<?= Url::toRoute(['content/view', 'id' => $model->id]) ?>" class="">继续阅读</a>
				</div>
			</div>
		</div>
	</div>



