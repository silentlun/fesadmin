<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Content');
$this->params['subtitle'] = Yii::t('app', 'Update Content');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
