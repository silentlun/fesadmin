<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('app', 'List');
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
    <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <?= Bar::widget(['template' => '{create} {delete}']) ?>
      </div>
    </div>
    <div class="card-body">
    <form id="myform">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn', 'headerOptions' => ['width' => '40']],

            'id',
            'username',
            [
                'attribute' => 'role_id',
                'header' => '角色',
                'width' => '80',
                'format' => 'raw',
                'value'  => function($model){
                return $model->roles[$model->role_id];
                },
                'filter' => User::getRoles(),
            ],
            'mobile',
            'email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value'  => function($model){
                return $model->textStatus[$model->status];
                },
                'filter' => User::getStatuses(),
            ],
            [
                'attribute' => 'created_at',
                'class' => 'backend\components\grid\DateColumn',
                'filter' => false,
            ],

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 150],
            ],
        ],
    ]); ?>
        
      
    </div>
    </form>
    <?php Pjax::end(); ?>
  </div>