<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = '';

?>
<style>html,body,.row{height:100%}#alert-container{height:calc(100% - 260px)}</style>
<div class="container" id="alert-container">
<div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading mb-3"><i class="fa fa-info-circle"></i> 提示信息</h4>
  <h6 class="py-3"><i class="fa fa-check"></i> 恭喜你，参赛报名成功！管理员将尽快完成审核。</h6>
  <hr>
  <p class="mb-0"><i class="fa fa-arrow-circle-right"></i> <a href="<?=Url::toRoute(['member/contest'])?>" class="alert-link">点击查看我的组队信息 </a></p>
</div>
  </div>
</div>
</div>
		
