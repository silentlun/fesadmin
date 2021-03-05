<?php

use yii\helpers\Html;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use backend\widgets\Bar;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
    <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <div class="card-toolbar clearfix">
      <div class="toolbar-btn-action">
      <?= Bar::widget(['template' => '{create}']) ?>
      </div>
    </div>
    <div class="card-body">
      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'username',
                'width' => '',
            ],
            [
                'attribute' => 'role',
                'width' => '150',
                'value' => function ($model) {
                /** @var $model backend\models\User */
                return $model->getRolesNameString();
                },
            ],
            [
                'attribute' => 'last_login_time',
                'width' => '150',
                'value' => function ($model) {
                return $model->last_login_time ? date('Y-m-d H:i:s', $model->last_login_time) : '';
                },
            ],
            [
                'attribute' => 'last_login_ip',
                'width' => '150',
            ],
            [
                'attribute' => 'status',
                'header' => '状态',
                'format' => 'raw',
                'value'  => function($model){
                return $model->status == 10 ? '<label class="label bg-success">正常</label>' : '<label class="label bg-dark">禁用</label>';
                }
            ],

            [
                'class' => 'backend\components\grid\ActionColumn',
                'buttons' => [
                    'delete' => function($url, $model, $key){
                    $data['id'] = $key;
                        return Html::a('<i class="fa fa-ban"></i> '.Yii::t('app', 'Delete'), ['delete', 'id' => $key], [
                            'title' => Yii::t('app', 'Delete'),
                            'data-pjax' => '0',
                            'class' => $key==1 ? 'btn btn-danger btn-xs disabled' : 'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this data?'),
                                'method' => 'post',
                                'params' => json_encode($data),
                            ]
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
      
      
    </div>
    <?php Pjax::end(); ?>
  </div>

