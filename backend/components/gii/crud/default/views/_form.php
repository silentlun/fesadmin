<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<?="<?= \$this->render('/widgets/_page-heading') ?>\n"?>
<div class="card">
  
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a><?= "<?= " ?>$this->params['subtitle'] ?></a></li>
  </ul>
  <div class="card-body">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>

    <?="<?= \$form->defaultButtons() ?>\n"?>

    <?= "<?php " ?>ActiveForm::end(); ?>
  </div>
</div>
