<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use common\models\Contest;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contest Datas');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('app', 'List');
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
    <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <?= Bar::widget(['template' => '{verify} {delete}']) ?>
      <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
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
                'attribute' => 'id',
                'value' => function($model){
                return $model->type['subname'].$model->id;
                }
            ],
            [
                'attribute' => 'title',
                'width' => '',
            ],
            [
                'attribute' => 'type_id',
                'width' => 150,
                'value' => function($model){
                return $model->type['name'];
                },
                'filter' => Contest::getTypeList(),
            ],
            [
                'attribute' => 'username',
                'label' => '创建人',
                'width' => '100',
                'value' => 'user.username',
                'filter' => Html::activeTextInput($searchModel, 'username',['class'=>'form-control']),
            ],
            [
                'attribute' => 'student',
                'format' => 'raw',
                'value' => function($model){
                return $model->students;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'teacher',
                'format' => 'raw',
                'value' => function($model){
                return $model->teachers;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'file',
                'format' => 'raw',
                'value' => function($model){
                return Html::a('<i class="fa fa-cloud-download"></i>下载',Yii::$app->config->site_upload_url.$model->file);
                },
                'filter' => false,
            ],
            [
                'attribute' => 'status',
                'header' => '状态',
                'width' => '100',
                'format' => 'raw',
                'value'  => function($model){
                return $model->textStatus[$model->status];
                },
                'filter' => Contest::getLabelStatus(),
            ],
            [
                'attribute' => 'created_at',
                'class' => 'backend\components\grid\DateColumn',
                'filter' => false,
            ],
            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => '60'],
                'buttons' => [
                    'verify' => function($url, $model, $key){
                    if($model->status == $model::STATUS_INACTIVE){
                        return Html::a('<i class="fa fa-check-square-o"></i> 审核', $url, [
                            'title' => '审核',
                            'data-toggle' => 'modal',
                            'data-target' => '#ajaxModal',
                            'data-pjax' => '0',
                            'class' => 'btn btn-warning  btn-xs btn-block verify',
                        ]);
                    }
                    
                },
                'update' => function($url, $model, $key){
                
                    return Html::a('<i class="fa fa-edit"></i> 编辑', $url, [
                        'title' => '编辑',
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModal',
                        'data-pjax' => '0',
                        'class' => 'btn btn-success btn-xs btn-block update',
                    ]);
                
                
                },
                'delete' => function($url, $model, $key){
                $data = ['id' => $key];
                return Html::a('<i class="fa fa-ban"></i> '.Yii::t('app', 'Delete'), $url, [
                    'class' => 'btn btn-danger btn-xs btn-block',
                    'title' => Yii::t('app', 'Delete'),
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this data?'),
                        'method' => 'post',
                        'params' => json_encode($data),
                    ]
                ]);
                },
                
                ],
                'template' => '{verify} {update} {delete}',
            ],
        ],
    ]); ?>
        
    </form>  
    </div>
    
    <?php Pjax::end(); ?>
  </div>