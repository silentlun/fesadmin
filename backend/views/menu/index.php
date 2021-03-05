<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
//print_r($dataProvider);exit;
$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
        <?php Pjax::begin(['id' => 'pjax-container']); ?>
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
            //'parentid',
            'route:text:路由',
            //'data',
            //'icon',
            //'listorder',
            //'display',

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 260],
                'buttons' => [
                    'create' => function($url, $model, $key){
                    return Html::a('<i class="fa fa-plus"></i> 添加子菜单', ['create', 'id' => $key], [
                        'title' => '添加子菜单',
                        'data-pjax' => '0',
                        'class' => 'btn btn-info btn-xs m-r-5',
                    ]);
                    },
                    'update' => function($url, $model, $key){
                    return Html::a('<i class="fa fa-edit"></i> 编辑', ['update', 'id' => $key, 'name' => $model['route']], [
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
        <?php Pjax::end(); ?>
  </div>