<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContestData */

$this->title = Yii::t('app', 'Contest Datas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row m-t-20">
    <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h4>参赛小组信息表导出</h4>
          </div>
          <div class="card-body">
            <p>导出完整的参赛小组信息数据</p>
            <p><?=Html::a('导出EXCEL', ['manage', 'type' => 'all'], ['class' => 'btn btn-primary'])?></p>
          </div>
        </div>
      
    </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h4>参赛小组简表导出</h4>
          </div>
          <div class="card-body">
            <p>按提交的参赛作品导出小组信息数据</p>
            <p><?=Html::a('导出EXCEL', ['manage', 'type' => 'simple'], ['class' => 'btn btn-primary'])?></p>
            
          </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h4>学生统计表导出</h4>
          </div>
          <div class="card-body">
            <p>导出全部学生参赛数据</p>
            <p><?=Html::a('导出EXCEL', ['manage', 'type' => 'student'], ['class' => 'btn btn-primary'])?></p>
            
          </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h4>教师统计表导出</h4>
          </div>
          <div class="card-body">
            <p>导出全部老师参赛数据</p>
            <p><?=Html::a('导出EXCEL', ['manage', 'type' => 'teacher'], ['class' => 'btn btn-primary'])?></p>
            
          </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <h4>清空报名数据</h4>
          </div>
          <div class="card-body">
            <div class="alert alert-warning" role="alert"><p>警告：该操作会删除所有报名数据和上传的附件，删除后将无法恢复，请谨慎操作！</p></div>
            <p><?=Html::a('清空报名数据', ['clear'], ['class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#ajaxModal',])?></p>
            
            
          </div>
        </div>
    </div>
</div>