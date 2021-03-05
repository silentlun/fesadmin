<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Constants;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('app', 'List');
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
    <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <?= Bar::widget() ?>
      </div>
    </div>
    <div class="card-body">
    <form id="myform">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn', 'headerOptions' => ['width' => '40']],
            [
                'attribute' => 'sort',
                'class' => 'backend\components\grid\SortColumn',
            ],

            'id',
            [
                'attribute' => 'title',
                'width' => '',
            ],
            [
                'attribute' => 'url',
                'width' => '',
            ],
            //'url:url',
            [
                'attribute' => 'status',
                'value'  => function($model){
                return Constants::getShowHideItems($model->status);
            }
            ],
            

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 150],
            ],
        ],
    ]); ?>
        
    </form>  
    </div>
    
    <?php Pjax::end(); ?>
  </div>