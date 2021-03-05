<?php
/**
 * SortColumn.php
 * @author: allen
 * @date  2020年6月11日上午11:36:29
 * @copyright  Copyright igkcms
 */
namespace backend\components\grid;

use yii\helpers\Html;
class SortColumn extends DataColumn
{
    //public $attribute = 'listorder';
    public $options = ['class' => 'form-control input-sm'];
    
    public function init()
    {
        parent::init();
        $this->headerOptions['width'] = '80';
        $this->content = function($model, $key, $index, $column){
            return Html::input('text', "listorders[{$key}]", $model[$this->attribute], $this->options);
        };
    }
}