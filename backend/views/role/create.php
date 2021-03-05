<?php


/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

$this->title = Yii::t('app', 'Roles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Roles'), 'url' => ['rolelist']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle'] = Yii::t('app', 'Create Role');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
