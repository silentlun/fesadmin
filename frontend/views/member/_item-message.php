<?php
use yii\helpers\Html;
?>
<div class="message-header d-flex justify-content-between">
    <h6 class="card-title"><?= $model->title ?> <?= $model->status == 0 ? '<span class="badge badge-danger">未读</span>' : '' ?> </h6>
    <div class="">
    <?php 
    if ($model->status == 0) {
        echo Html::a('设为已读', ['message-status'], ['class' => 'btn btn-info btn-xs message-operation', 'data-id' => $model->id]);
    } else {
        echo Html::tag('span', '已读', ['class' => 'btn btn-light btn-xs disabled']);
    }
    ?>
    <?= Html::a('删除', ['message-delete'], ['class' => 'btn btn-danger btn-xs message-operation', 'data-id' => $model->id, 'data-confirm' => Yii::t('app', 'Really to delete?')]) ?>
    </div>
  </div>
  <div class="message-date"><i class="fa fa-clock-o"></i> <?= date('Y-m-d', $model->created_at) ?></div>
  <p><?= $model->content ?></p>




