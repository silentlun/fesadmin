<?php


/* @var $this yii\web\View */
/* @var $model common\models\ContestType */

$this->title = Yii::t('app', 'Contest Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Contest Type');
$this->params['subtitle'] = Yii::t('app', 'Update Contest Type');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
