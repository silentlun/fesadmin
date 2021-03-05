<?php


/* @var $this yii\web\View */
/* @var $model common\models\Partner */

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create Partner');
$this->params['subtitle'] = Yii::t('app', 'Create Partner');
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

