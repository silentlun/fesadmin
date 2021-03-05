<?php
use yii\helpers\Html;
use frontend\widgets\ListView;

$this->title = '站内消息';
?>
<div class="container my-5">
	<div class="row">
		<div class="col-md-3">
		<?= $this->render('_left') ?>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="headline d-flex justify-content-between">
						<h4 class="head-title">站内消息</h4>
					</div>
					<?= ListView::widget([
        		    'id' => 'messagelist',
                    'dataProvider' => $dataProvider,
        		    'options' => ['class' => 'mt-4'],
				    'itemOptions' => [
				        'tag' => 'div',
				        'class' => 'message-list'
				    ],
        		    'itemView' => '_item-message',
        		    'layout' => '{items}{pager}',
        		    'pager' => [
        		        'maxButtonCount' => 10,
        		        'nextPageLabel' => '下一页',
        		        'prevPageLabel' => '上一页',
        		    ],
                ]) ?>
					
				</div>
			</div>
		</div>
	</div>
</div>
