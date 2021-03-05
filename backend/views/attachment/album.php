<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

?>
<style>
body{background-color: #FFFFFF;}
.form-inline .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
}
.form-inline .form-control {
    display: inline-block;
    width: auto;
    vertical-align: middle;
}
.border-color-gray {
			    border: 1px solid #e7eaec;
			}
			.mailbox-attachments {
				list-style: none;
				margin: 0;
				padding: 0;
				margin-top: 20px;
			}
			.mailbox-attachments li {
				float: left;
				border: 1px solid #eee;
				width: 25%;
				border: 0;
				margin-bottom: 0;
				margin-right: 0;
				padding: 5px;
			}
			.mailbox-attachments .active {
			    border: 1px solid #62a8ea !important;
			    box-sizing: border-box;
			}
			
			.mailbox-attachment-name {
				font-weight: bold;
				color: #666
			}
			.mailbox-attachment-info span {
			    width: 100%;
			    text-overflow: ellipsis;
			    white-space: nowrap;
			    overflow: hidden;
			    margin: 0;
			    display: block;
			}
			
			.mailbox-attachment-icon,
			.mailbox-attachment-info,
			.mailbox-attachment-size {
				display: block
			}
			
			.mailbox-attachment-info {
				padding: 10px;
				background: #f4f4f4;
			}
			
			.mailbox-attachment-size {
				color: #999;
				font-size: 12px
			}
			
			.mailbox-attachment-icon {
				text-align: center;
				font-size: 65px;
				color: #666;
				padding: 20px 10px
			}
			
			.mailbox-attachment-icon.has-img {
				padding: 0
			}
			
			.mailbox-attachment-icon.has-img>img {
				max-width: 100%;
				height: auto
			}
</style>
<form class="form-inline">
	<div class="form-group">
		<label for="exampleInputName2">日期</label>
		<input type="text" class="form-control" id="exampleInputName2">
	</div>
	<div class="form-group">
		<label for="exampleInputName2">名称</label>
		<input type="text" class="form-control" id="exampleInputName2">
	</div>
	<button type="submit" class="btn btn-primary">搜索</button>
</form>

<?=ListView::widget([
    'id' => 'rfAttachmentList',
    'dataProvider' => $dataProvider,
    'options' => ['tag' => 'ul', 'class' => 'mailbox-attachments clearfix'],
    'itemOptions' => [
        'tag' => 'li',
    ],
    'itemView' => '_item-album',
    'layout' => '{items}{pager}',
    'pager' => [
        'maxButtonCount' => 5,
        'nextPageLabel' => '下一页',
        'prevPageLabel' => '上一页',
    ],
]);?>
