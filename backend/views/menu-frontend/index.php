<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use common\helpers\Constants;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu Frontends');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('app', 'List');
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
                'attribute' => 'name',
                'width' => '',
                'format' => 'raw',
                'label' => '名称'
            ],
            [
                'attribute' => 'route',
                'width' => '',
            ],
            [
                'attribute' => 'display',
                'format' => 'raw',
                'value'  => function($model){
                return Constants::getShowHideItems($model['display']);
            }
            ],

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 260],
                'buttons' => [
                    'create' => function($url, $model, $key){
                    return Html::a('<i class="fa fa-plus"></i> 添加子菜单', $url, [
                        'title' => '添加子菜单',
                        'data-pjax' => '0',
                        'class' => 'btn btn-info btn-xs m-r-5',
                    ]);
                },
                'update' => function($url, $model, $key){
                return Html::a('<i class="fa fa-edit"></i> 编辑', $url, [
                    'title' => '编辑',
                    'data-pjax' => '0',
                    'class' => 'btn btn-success btn-xs m-r-5',
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