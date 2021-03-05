<?php if ($showType == 'thumb'):?>
<div class="upload-image-warp" id="file_<?php echo $hashVar;?>">
	<div class="upload-btn-box <?php echo $hashVar;?>" id="upload_btn_<?php echo $hashVar;?>"<?=isset($inputValue) && $inputValue?' style="display: none;"':''?>>
		<div class="upload-image-btn">
		    <i class="fa fa-cloud-upload"></i>
		<h5>点击上传</h5>
		</div>
	</div>
	<div class="upload-image-box" id="upload_box_<?php echo $hashVar;?>"<?=isset($inputValue) && $inputValue?'':' style="display: none;"'?>>
		<img class="upload-image-preview" id="thumb_preview_<?php echo $hashVar;?>" src="<?php echo $inputValue;?>">
		<div class="upload-image-hover">
			<div class="upload-image-delete"><i class="fa fa-times-circle"></i></div>
		</div>
	</div>
	<input type="hidden" name="<?=$inputName?>" value="<?=isset($inputValue)?$inputValue:''?>" id="thumb_input_<?php echo $hashVar;?>">
</div>

<?php else:?>
<div class="input-group">
  <input type="text" class="form-control" name="<?=$inputName?>" value="<?=isset($inputValue)?$inputValue:''?>" id="thumb_input">
  <span class="input-group-btn">
    <button class="btn btn-success <?php echo $hashVar;?>" type="button">选择文件</button>
  </span>
</div>
<?php endif;?>