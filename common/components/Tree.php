<?php
namespace common\components;

/**
 * Tree.php
 * @author: allen
 * @date  2020年12月17日上午10:48:49
 * @copyright  Copyright igkcms
 */
use yii\base\BaseObject;

class Tree extends BaseObject
{
    public $items = [];
    public $icon = ['│','├','└'];
    public $nbsp = '&nbsp';
    public $strResult = '';
    public $arrResult = [];
    
    public function __construct($config = [])
    {
        parent::__construct($config);
    }
    
    /**
     * 获取子分类
     *@param:
     *@return:
     */
    public function getChild($myid = 0)
    {
        $array = [];
        foreach ($this->items as $id => $item) {
            if ($item['parentid'] == $myid) $array[$id] = $item;
        }
        return $array;
    }
    
    public function getTree($myid = 0, $fieldName = 'name', $adds = '')
    {
        $return = [];
        $child = $this->getChild($myid);
        if (empty($child)) return $return;
        $total = count($child);
        $number = 1;
        $j = $k = '';
        foreach ($child as $id => $value){
            if ($number == $total){
                $j = $this->icon[2];
            } else {
                $j = $this->icon[1];
                $k = $adds ? $this->icon[0] : '';
            }
            $spaces = $adds ? $adds.$j : '';
            $value[$fieldName] = $spaces.$value[$fieldName];
            $return[$id] = $value[$fieldName];
            $this->getTree($id, $fieldName, $adds.$k.$this->nbsp);
            $number++;
        }
        return $return;
    }
}