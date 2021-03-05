<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create Menu');
$this->params['subtitle'] = Yii::t('app', 'Create Menu');
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

