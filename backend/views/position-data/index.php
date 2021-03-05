<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Position Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
        <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <?= Bar::widget(['template' => '{listorder} {delete}']) ?>
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
            'content_id',
            [
                'attribute' => 'title',
                'width' => '',
                'value' => function($model){
                $r = \yii\helpers\Json::decode($model->data);
                return $r['title'];
            }
            ],
            [
                'attribute' => 'catid',
                'label' => '所属栏目',
                'value' => function($model){
                return $model->category ? $model->category->catname : Yii::t('app', 'uncategoried');
            }
            ],
            [
                'attribute' => 'created_at',
                'class' => 'backend\components\grid\DateColumn',
            ],

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 150],
                'buttons' => [
                    'update' => function($url, $model, $key){
                    return Html::a('<i class="fa fa-edit"></i> 编辑', ['content/update', 'id' => $model->content_id], [
                        'title' => '编辑',
                        'data-pjax' => '0',
                        'class' => 'btn btn-success btn-xs m-r-5',
                    ]);
                },
                ],
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
        
    </form>  
    </div>
        <?php Pjax::end(); ?>
  </div>