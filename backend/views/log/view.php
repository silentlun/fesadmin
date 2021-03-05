<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="ajaxModalLabel">日志详情</h4>
  </div>
  <div class="modal-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'admin.username',
            'route',
            'description:ntext',
            'created_at:datetime',
        ],
        'template' => '<tr><th style="width: 80px;">{label}</th><td>{value}</td></tr>',
    ]) ?>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
  </div>
