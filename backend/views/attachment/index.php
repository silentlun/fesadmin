<?php

use yii\helpers\Html;
use backend\widgets\Bar;
use backend\components\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\JsBlock;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Attachments');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/widgets/_page-heading') ?>
  <div class="card animated fadeInRight">
  <ul class="nav nav-tabs page-tabs">
    <li class="active"><a href="<?=Url::to(['attachment/index'])?>">数据库模式</a></li>
    <li><a href="<?=Url::to(['attachment/directory'])?>">目录模式</a></li>
  </ul>
        <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <div class="card-toolbar clearfix">
      
      <div class="toolbar-btn-action">
      <?= Bar::widget(['template' => '{delete} {address}']) ?>
      </div>
    </div>
    <div class="card-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn', 'headerOptions' => ['width' => '40']],

            'id',
            'module',
            [
                'attribute' => 'filename',
                'width' => '',
                'format' => 'raw',
                'value' => function($model){
                $icon = \common\helpers\Util::attachmentIcon($model->fileext);
                $thumb = glob(dirname(Yii::getAlias('@uploads/').$model->filepath).'/thumb_*'.basename($model->filepath));
                $showthumb = $thumb ? ' <i class="fa fa-image text-info" style="cursor: pointer;" title="管理缩略图" onclick="showthumb(\''.Url::toRoute(['attachment/thumbs', 'id' => $model->id]).'\', \''.Html::encode($model->filename).'\')"></i>' : '';
                return '<i class="fa '.$icon.'"></i> '.$model->filename.$showthumb;
            }
            ],
            'fileext',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                return $model->status == 1 ? '<label class="label bg-success">已使用</label>' : '<label class="label bg-dark">未使用</label>';
            }
            ],
            [
                'attribute' => 'filesize',
                'width' => '150',
                'value' => function($model){
                if($model->filesize >= 1073741824) {
                    $filesize = round($model->filesize / 1073741824 * 100) / 100 . ' GB';
                } elseif($model->filesize >= 1048576) {
                    $filesize = round($model->filesize / 1048576 * 100) / 100 . ' MB';
                } elseif($model->filesize >= 1024) {
                    $filesize = round($model->filesize / 1024 * 100) / 100 . ' KB';
                } else {
                    $filesize = $model->filesize . ' Bytes';
                }
                return $filesize;
            }
            ],
            [
                'attribute' => 'created_at',
                'class' => 'backend\components\grid\DateColumn',
            ],

            [
                'class' => 'backend\components\grid\ActionColumn',
                'headerOptions' => ['width' => 150],
                'template' => '{view-layer} {delete}',
            ],
        ],
    ]); ?>
        
      
    </div>
        <?php Pjax::end(); ?>
  </div>
  
<?php JsBlock::begin() ?>
<script>

    function showthumb(url, name) {
    	layer.open({
            type: 2,
            title: name,
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['70%', '80%'],
            content: url,
        });
        return false;
    }
</script>
<?php JsBlock::end() ?>