<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
$this->title = '网站维护中';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= Html::encode($this->title) ?> - <?= Html::encode(Yii::$app->config->site_title) ?></title>
    <meta name="keywords" content="<?= Html::encode(Yii::$app->config->site_keywords) ?>">
    <meta name="description" content="<?= Html::encode(Yii::$app->config->site_description) ?>">
    <?php $this->registerCsrfMetaTags() ?>
    
    <?php $this->head() ?>
    <style>html,body {height: 100%}</style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container h-100">
  <div class="row justify-content-md-center align-items-center h-100">
    <div class="col-md-8">
      <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading text-center">网站维护中...</h4>
  <p class="text-center">网站正在维护中，请稍后访问。</p>
</div>
    </div>
  </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
