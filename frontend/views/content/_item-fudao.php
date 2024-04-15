<?php
use yii\helpers\Url;
use common\helpers\Util;
?>
<div class="date-formats mr-3"> <span><?= date('d', $model->created_at) ?></span> <small><?= date('m/Y', $model->created_at) ?></small> </div>
  <div class="media-body">
    <h5 class="media-heading"><a href="<?=$model->url?>" target="_blank"><?= $model->title ?></a></h5>
    <p><?= $model->description ?></p>
  </div>



