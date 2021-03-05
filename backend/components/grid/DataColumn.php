<?php
/**
 * DataColumn.php
 * @author: allen
 * @date  2020年6月11日上午11:29:43
 * @copyright  Copyright igkcms
 */
namespace backend\components\grid;

class DataColumn extends \yii\grid\DataColumn
{
    public $width = '80';
    
    public function init()
    {
        parent::init();
        if ($this->width){
            $this->headerOptions['width'] = $this->width;
        }
    }
}