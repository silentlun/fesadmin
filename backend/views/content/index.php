<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\JsBlock;
use common\models\Category;
use common\helpers\Tree;
use yii\helpers\Url;

use backend\components\grid\SortColumn;
use common\helpers\Util;
use common\helpers\Constants;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = $this->title.Yii::t('app', 'List');

?>
<?= $this->render('/widgets/_page-heading') ?>
<div class="row-sm">
  
  <div class="col-md-2">
  <?= $this->render('/widgets/_categorys') ?>
  </div>
  <div class="col-md-10">
    <div class="full-height">
      
      <div class="card full-height-scroll">
        <?php Pjax::begin(['id' => 'pjax-container']); ?>
        <div class="card-toolbar clearfix">
          
          <div class="toolbar-btn-action pull-left">
          <?= Bar::widget() ?>
          </div>
          
        </div>
        <div class="card-body">
        <form id="myform">
          <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'format' => 'raw',
                'value' => function($model){
                $thumb = $model->thumb ? ' <i class="fa fa-image text-info"></i>' : '';
                $posid =  $model->posid ? ' <i class="fa fa-flag text-danger"></i>' : '';
                return $model->title.$thumb.$posid;
                }
            ],
            [
                'attribute' => 'status',
                'header' => '状态',
                'width' => '80',
                'format' => 'raw',
                'value'  => function($model){
                    return $model->status == 99 ? '<label class="label label-success">发布</label>' : '<label class="label label-default">隐藏</label>';
                },
                'filter' => Constants::getContentStatus(),
            ],
            [
                'attribute' => 'created_at',
                'class' => 'backend\components\grid\DateColumn',
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
    </div>
  </div>
</div>

