<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Constants;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
    
    <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <?= Bar::widget(['template' => '{create} {listorder}']) ?>
      </div>
    </div>
    <div class="card-body">
    <form id="myform">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'sort',
                'class' => 'backend\components\grid\SortColumn',
                'label' => '排序'
            ],

            'id',
            [
                'attribute' => 'catname',
                'width' => '',
                'format' => 'raw',
                'label' => '名称'
            ],
            [
                'attribute' => 'type',
                'header' => '栏目类型',
                'format' => 'raw',
                'value'  => function($model){
                return $model['type'] ? '<span class="text-info">单网页</span>' : '内部栏目';
            }
            ],
            'catdir:text:目录',
            [
                'attribute' => 'ismenu',
                'header' => '导航显示',
                'format' => 'raw',
                'value'  => function($model){
                return Constants::getShowHideItems($model['ismenu']);;
            }
            ],

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 260],
                'buttons' => [
                    'create' => function($url, $model, $key){
                    return Html::a('<i class="fa fa-plus"></i> 添加子栏目', ['create', 'id' => $key], [
                        'title' => '添加子栏目',
                        'data-pjax' => '0',
                        'class' => 'btn btn-info btn-xs m-r-5',
                    ]);
                }
                ],
                'template' => '{create} {update} {delete}',
            ],
        ],
    ]); ?>
        
    </form>  
    </div>
    
  </div>