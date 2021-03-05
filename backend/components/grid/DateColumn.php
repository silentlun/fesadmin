<?php
/**
 * DateColumn.php
 * @author: allen
 * @date  2020年6月11日下午1:57:32
 * @copyright  Copyright igkcms
 */
namespace backend\components\grid;

class DateColumn extends DataColumn
{
    public $format = ['datetime', 'php:Y-m-d H:i'];
    public function init()
    {
        parent::init();
        $this->headerOptions['width'] = '130';
    }
}