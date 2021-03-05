<?php


/* @var $this yii\web\View */
/* @var $model common\models\Partner */

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Partner');
$this->params['subtitle'] = Yii::t('app', 'Update Partner');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
