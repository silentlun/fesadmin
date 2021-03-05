<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Position */

$this->title = Yii::t('app', 'Positions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Position');
$this->params['subtitle'] = Yii::t('app', 'Update Position');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
