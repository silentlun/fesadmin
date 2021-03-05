<?php
/**
* page-heading 
*
* @author  Allen
* @date  2020-4-7 上午11:32:00
* @copyright  Copyright igkcms
*/
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<div class="content-header">
	<?= Breadcrumbs::widget([
        'homeLink' => false,
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
    ?>
	<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
</div>
