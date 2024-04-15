<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\widgets\JsBlock;

$this->title = '我的组队';
?>
<div class="container my-5">
	<div class="row">
		<div class="col-md-3">
		<?= $this->render('_left') ?>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
				<ul class="nav nav-tabs">
              <li class="nav-item">
                <?=Html::a('自己的团队', ['contest'], ['class' => 'nav-link active'])?>
              </li>
              <li class="nav-item">
                <?=Html::a('加入的团队', ['contest-team'], ['class' => 'nav-link'])?>
              </li>
            </ul>
					
					<div class="mt-4">
					<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'num',
            'label' => '编号',
            'headerOptions' => [
                'width' => '60'
            ],
            'value' => function($model){
            return $model->status == $model::STATUS_ACTIVE ? $model->type->subname.$model->id : '';
			},
        ],
        'title',
        [
            'attribute' => 'type_id',
            'value' => function($model){
            return $model->type['name'];
        },
        ],
        [
            'attribute' => 'username',
            'label' => '创建人',
            'value' => 'user.username',
        ],
        [
            'attribute' => 'student',
            'format' => 'raw',
            'headerOptions' => ['width' => '80'],
            'value' => function($model){
            return $model->students;
            },
            'filter' => false,
        ],
        [
            'attribute' => 'teacher',
            'format' => 'raw',
            'headerOptions' => ['width' => '80'],
            'value' => function($model){
            return $model->teachers;
        },
        'filter' => false,
        ],
        [
            'attribute' => 'file',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model){
            return Html::a('<i class="fa fa-cloud-download"></i>',Yii::$app->config->site_upload_url.$model->file);
        },
        'filter' => false,
        ],
        [
            'attribute' => 'status',
            'header' => '状态',
            'headerOptions' => [
                'width' => 80
            ],
            'format' => 'raw',
            'value'  => function($model){
            return $model->textStatus[$model->status];
        },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作', 
            'template' => '{contest-update}',
            'headerOptions' => [
                'width' => 20
            ],
            'contentOptions' => ['class' => 'text-center'],
            'buttons' => [
                'contest-update' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-edit"></i>', $url, [
                        'title' => '编辑',
                        'data-pjax' => '0'
                    ]);
                },
            ],
        ]
    ],
    'layout' => "{items}\n{summary}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered table-hover'
    ], 
    'showHeader' => true,
    'emptyText' => '暂时没有任何数据！',
    'emptyTextOptions' => [
        'style' => 'color:red;font-weight:bold'
    ],
    'showOnEmpty' => true,
    'pager' => [
        'firstPageLabel' => '首页',
        'prevPageLabel' => '上一页',
        'nextPageLabel' => '下一页',
        'lastPageLabel' => '尾页'
    ]
]);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php JsBlock::begin()?>
<script>

</script>
<?php JsBlock::end()?>