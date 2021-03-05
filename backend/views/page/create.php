<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create Page');
$this->params['subtitle'] = Yii::t('app', 'Create Page');
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

