<?php
use yii\helpers\Url;
?>

<div class="border-color-gray" data-id="<?=$model->id?>" data-name="<?=$model->filename?>" data-modal="<?=Yii::$app->request->get('modal')?>" data-url="<?=Yii::$app->config->site_upload_url.$model->filepath?>"
 data-upload_type="images">
	<span class="mailbox-attachment-icon has-img">
		<img src="<?=Yii::$app->config->site_upload_url.$model->filepath?>" style="height: 100px">
	</span>
	<div class="mailbox-attachment-info">
		<span><i class="fa fa-paperclip"></i> <?=$model->filename?></span>

		<span class="mailbox-attachment-size">
			<?=$model->filesizeText?>
		</span>
	</div>
</div>


