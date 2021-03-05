<?php
/**
 * GridView.php
 * @author: allen
 * @date  2020年6月11日上午10:06:31
 * @copyright  Copyright igkcms
 */
namespace backend\components\grid;


class GridView extends \yii\grid\GridView
{
    public $dataColumnClass = 'backend\components\grid\DataColumn';
    public $options = ['class' => 'table-responsive'];
    
    public $tableOptions = ['class' => 'table table-hover'];
    
    public $layout = "{items}\n<div class='row-page'><div class='col-sm-3'>{summary}</div><div class='col-sm-9 text-right'>{pager}</div></div>";
    
    public $pager = [
        'firstPageLabel' => '首页',
        'prevPageLabel' => '上一页',
        'nextPageLabel' => '下一页',
        'lastPageLabel' => '尾页'
    ];
    
    public $emptyText = '暂时没有任何数据！';
    public $emptyTextOptions = ['style' => 'color:red;font-weight:bold'];
    
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        parent::run();
    }
}