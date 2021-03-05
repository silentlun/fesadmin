<?php


/* @var $this yii\web\View */
/* @var $model common\models\UserGroup */

$this->title = Yii::t('app', 'User Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create User Group');
$this->params['subtitle'] = Yii::t('app', 'Create User Group');
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

