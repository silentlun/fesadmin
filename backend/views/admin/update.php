<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

$this->title = Yii::t('app', 'Admins');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Admin');
?>
<?php
if (Yii::$app->controller->action->id == 'update') {
    echo $this->render('_form', [
        'model' => $model,
        'subtitle' => Yii::t('app', 'Update Admin'),
    ]);
} else {
    echo $this->render('_form-update-self', [
        'model' => $model,
        'subtitle' => Yii::t('app', 'Update Self'),
    ]);
}
?>

