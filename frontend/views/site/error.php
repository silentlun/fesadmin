<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<section class="section bg-light">
<div class="container py-5" style="min-height: 300px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        服务器在处理您的请求中发生了以上错误。
    </p>
    <p>
        如果您认为这是服务器错误，请与我们联系。 谢谢。
    </p>

</div>
</section>
