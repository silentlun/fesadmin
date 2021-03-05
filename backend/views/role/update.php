<?php


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('app', 'Roles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Roles'), 'url' => ['roleindex']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Role');
$this->params['subtitle'] = Yii::t('app', 'Update Role');
?>
<?= $this->render('_form', [
        'model' => $model,
    ]) ?>