<?php
/**
 * Tree.php
 * @author: allen
 * @date  2020年4月17日上午8:57:24
 * @copyright  Copyright igkcms
 */
namespace common\helpers;

class Tree {
    public $arr = [];
    public $icon = ['│','├','└'];
    public $nbsp = '&nbsp';
    public $strResult = '';
    public $arrResult = [];
    
    public function __construct(array $arr){
        $this->arr = $arr;
    }
    
    /**
     * 获取子分类
     */
    public function getChild($myid){
        $array = [];
        foreach ($this->arr as $id=>$a){
            if ($a['parentid'] == $myid) $array[$id] = $a;
        }
        return $array;
    }
    
    /**
     * 获取树形数组（select使用）
     */
    public function getTree($myid = 0, $fieldName = 'name', $adds = ''){
        //获取子分类
        $child = $this->getChild($myid);
        if (empty($child)) return $this->arrResult;
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
            $this->arrResult[$id] = $value[$fieldName];
            $this->getTree($id, $fieldName, $adds.$k.$this->nbsp);
            $number++;
        }
        return $this->arrResult;
    }
    
    /**
     * 获取树形数组（gridView使用）
     */
    public function getGridTree($myid = 0, $fieldName = 'name', $adds = ''){
        //获取子分类
        $child = $this->getChild($myid);
        if (empty($child)) return $this->arrResult;
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
            $this->arrResult[$id] = $value;
            $this->getGridTree($id, $fieldName, $adds.$k.$this->nbsp);
            $number++;
        }
        return $this->arrResult;
    }
    
    /**
     * 同上一类方法，jquery treeview 风格，可伸缩样式（需要treeview插件支持）
     * @param $myid 表示获得这个ID下的所有子级
     * @param $effected_id 需要生成treeview目录数的id
     * @param $str 末级样式
     * @param $str2 目录级别样式
     * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
     * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
     * @param $currentlevel 计算当前层级，递归使用 适用改函数时不需要用该参数
     * @param $recursion 递归使用 外部调用时为FALSE
     */
    public function getViewTree($myid,$effected_id='example',$liststr="<span class='file'>\$name</span>", $str2="<span class='folder'>\$name</span>", $pagestr="<span class='file'>\$name</span>", $showlevel = 0, $style='filetree treeview ', $currentlevel = 1, $recursion=FALSE) {
        $child = $this->getChild($myid);
        if(!defined('EFFECTED_INIT')){
            $effected = ' id="'.$effected_id.'"';
            define('EFFECTED_INIT', 1);
        } else {
            $effected = '';
        }
        $placeholder = 	'<ul><li><span class="placeholder"></span></li></ul>';
        if(!$recursion) $this->strResult .='<ul'.$effected.'  class="'.$style.'">';
        foreach($child as $id=>$a) {
            
            @extract($a);
            if($showlevel > 0 && $showlevel == $currentlevel && $this->getChild($id)) $folder = 'hasChildren'; //如设置显示层级模式@2011.07.01
            $floder_status = isset($folder) ? ' class="'.$folder.'"' : '';
            $this->strResult .= $recursion ? '<ul><li'.$floder_status.' id=\''.$id.'\'>' : '<li'.$floder_status.' id=\''.$id.'\'>';
            $recursion = FALSE;
            if($this->getChild($id)){
                eval("\$nstr = \"$str2\";");
                $this->strResult .= $nstr;
                if($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
                    $this->getViewTree($id, $effected_id, $liststr, $str2, $pagestr, $showlevel, $style, $currentlevel+1, TRUE);
                } elseif($showlevel > 0 && $showlevel == $currentlevel) {
                    $this->strResult .= $placeholder;
                }
            } else {
                if ($type == 0) {
                    eval("\$nstr = \"$liststr\";");
                } else {
                    eval("\$nstr = \"$pagestr\";");
                }
                
                $this->strResult .= $nstr;
            }
            $this->strResult .=$recursion ? '</li></ul>': '</li>';
        }
        if(!$recursion)  $this->strResult .='</ul>';
        return $this->strResult;
    }
    
    public function getTableTree($myid, $str, $sid = 0, $adds = '', $str_group = '') {
        $number = 1;
        $child = $this->getChild($myid);
        if(is_array($child)){
            $total = count($child);
            foreach($child as $id=>$value){
                $j=$k='';
                if($number==$total){
                    $j .= $this->icon[2];
                }else{
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds.$j : '';
                $selected = $id==$sid ? 'selected' : '';
                @extract($value);
                $parentid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
                $this->strResult .= $nstr;
                $nbsp = $this->nbsp;
                $this->getTableTree($id, $str, $sid, $adds.$k.$nbsp,$str_group);
                $number++;
            }
        }
        return $this->strResult;
        
    }
}
