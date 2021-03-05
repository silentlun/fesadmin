<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = '提示信息';
?>
<style>html,body,.row{height:100%}#alert-container{height:calc(100% - 260px)}</style>
<div class="container" id="alert-container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6">
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading mb-3"><i class="fa fa-info-circle"></i> 提示信息</h4>
          <p>恭喜你，账号注册成功!</p>
          <hr>
          <p class="mb-0"><a href="{strip_tags($url_forward)}" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a></p>
        </div>
      </div>
    </div>
</div>

<style>html,body,.row{height:100%}#alert-container{height:calc(100% - 260px)}</style>
<div class="container" id="alert-container">
<div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading mb-3"><i class="fa fa-info-circle"></i> 提示信息</h4>
  <h6 class="py-3">恭喜你，账号注册成功!</h6>
  <hr>
  <p class="mb-0"><a href="{strip_tags($url_forward)}" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a></p>
</div>
  </div>
</div>
</div>
